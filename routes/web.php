<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FaturaController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// Rotas de Autenticação
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/login', function () {
    return view('auth.login');
})->name('login.view');

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('/clientes/{cliente}/faturas', [ClienteController::class, 'faturas'])->name('clientes.faturas');
    Route::get('/clientes/{cliente}/consumo', [ClienteController::class, 'consumo'])->name('clientes.consumo');

    // Faturas
    Route::resource('faturas', FaturaController::class);
    Route::post('/faturas/{fatura}/pagar', [FaturaController::class, 'registrarPagamento'])->name('faturas.pagar');
    Route::get('/faturas/{fatura}/imprimir', [FaturaController::class, 'imprimir'])->name('faturas.imprimir');
    Route::get('/faturas/relatorios/mensal', [FaturaController::class, 'relatorioMensal'])->name('faturas.relatorio.mensal');

    // Consumo
    Route::resource('consumos', ConsumoController::class);
    Route::post('/consumos/leitura-em-massa', [ConsumoController::class, 'leituraEmMassa'])->name('consumos.leitura.massa');
    Route::get('/consumos/relatorios/media', [ConsumoController::class, 'relatorioMediaConsumo'])->name('consumos.relatorio.media');

    // Perfil do Usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Configurações do Sistema
    Route::prefix('configuracoes')->group(function () {
        Route::get('/', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
        Route::patch('/tarifas', [ConfiguracaoController::class, 'atualizarTarifas'])->name('configuracoes.tarifas');
        Route::patch('/impostos', [ConfiguracaoController::class, 'atualizarImpostos'])->name('configuracoes.impostos');
    });

    // Exportação de Dados
    Route::prefix('exportar')->group(function () {
        Route::get('/clientes', [ExportController::class, 'clientes'])->name('export.clientes');
        Route::get('/faturas', [ExportController::class, 'faturas'])->name('export.faturas');
        Route::get('/consumos', [ExportController::class, 'consumos'])->name('export.consumos');
    });
});

// Rotas Administrativas (apenas para Admins)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('clientes', ClienteController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});

// Importa as rotas de autenticação padrão do Laravel
require __DIR__.'/auth.php';
