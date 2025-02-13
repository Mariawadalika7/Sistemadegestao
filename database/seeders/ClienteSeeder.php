<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Consumo;
use App\Models\Fatura;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        // Criar alguns clientes de exemplo
        $clientes = [
            [
                'nome' => 'João Silva',
                'cpf_cnpj' => '123.456.789-00',
                'email' => 'joao@example.com',
                'telefone' => '(11) 99999-9999',
                'endereco' => 'Rua Exemplo, 123',
                'tipo' => 'residencial',
                'status' => 'ativo'
            ],
            [
                'nome' => 'Empresa XYZ',
                'cpf_cnpj' => '12.345.678/0001-90',
                'email' => 'contato@empresaxyz.com',
                'telefone' => '(11) 98888-8888',
                'endereco' => 'Av Comercial, 456',
                'tipo' => 'comercial',
                'status' => 'ativo'
            ]
        ];

        foreach ($clientes as $clienteData) {
            $cliente = Cliente::create($clienteData);

            // Criar consumos para cada cliente
            for ($i = 1; $i <= 6; $i++) {
                $consumo = new Consumo([
                    'data_leitura' => now()->subMonths($i)->format('Y-m-d'),
                    'leitura_anterior' => rand(1000, 2000),
                    'leitura_atual' => rand(2001, 3000),
                    'consumo_kwh' => rand(100, 500),
                ]);
                $cliente->consumos()->save($consumo);

                // Criar fatura baseada no consumo
                $fatura = new Fatura([
                    'numero' => date('Ym') . str_pad($cliente->id, 4, '0', STR_PAD_LEFT) . $i,
                    'valor' => rand(100, 1000),
                    'data_emissao' => now()->subMonths($i)->format('Y-m-d'),
                    'data_vencimento' => now()->subMonths($i)->addDays(10)->format('Y-m-d'),
                    'status' => rand(0, 1) ? 'pago' : 'pendente',
                    'consumo_kwh' => $consumo->consumo_kwh,
                    'valor_kwh' => 0.92,
                    'impostos' => rand(10, 50),
                    'desconto' => 0
                ]);
                $cliente->faturas()->save($fatura);
            }
        }
    }
}
