<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Fatura;
use App\Models\Consumo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalClientes = Cliente::count();
        $faturamentoMensal = Fatura::whereMonth('created_at', Carbon::now()->month)->sum('valor');
        $consumoTotal = Consumo::whereMonth('data_leitura', Carbon::now()->month)->sum('consumo_kwh');
        $faturasPendentes = Fatura::where('status', 'pendente')->count();

        // Dados para o gráfico de consumo
        $dadosConsumo = Consumo::selectRaw('MONTH(data_leitura) as mes, SUM(consumo_kwh) as total')
            ->whereYear('data_leitura', Carbon::now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total')
            ->toArray();

        // Dados para o gráfico de distribuição
        $dadosDistribuicao = [
            Cliente::where('tipo', 'residencial')->count(),
            Cliente::where('tipo', 'comercial')->count(),
            Cliente::where('tipo', 'industrial')->count(),
        ];

        // Últimas faturas
        $ultimasFaturas = Fatura::with('cliente')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($fatura) {
                $fatura->status_cor = $this->getStatusColor($fatura->status);
                return $fatura;
            });

        return view('dashboard.index', compact(
            'totalClientes',
            'faturamentoMensal',
            'consumoTotal',
            'faturasPendentes',
            'dadosConsumo',
            'dadosDistribuicao',
            'ultimasFaturas'
        ));
    }

    private function getStatusColor($status)
    {
        return [
            'pago' => 'success',
            'pendente' => 'warning',
            'atrasado' => 'danger',
            'processando' => 'info'
        ][$status] ?? 'secondary';
    }
}
