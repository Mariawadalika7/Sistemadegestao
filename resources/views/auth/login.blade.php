<!-- resources/views/dashboard/index.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Energia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-dashboard {
            transition: transform 0.2s;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
        }
        .nav-link {
            color: #ecf0f1;
        }
        .nav-link:hover {
            background: #34495e;
            color: #fff;
        }
        .chart-container {
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-users me-2"></i>Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-file-invoice me-2"></i>Faturas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-chart-line me-2"></i>Consumo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog me-2"></i>Configurações</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card card-dashboard bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total de Clientes</h5>
                                <h2 class="mb-0">{{ $totalClientes }}</h2>
                                <small>+5% este mês</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-dashboard bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Faturamento Mensal</h5>
                                <h2 class="mb-0">R$ {{ number_format($faturamentoMensal, 2, ',', '.') }}</h2>
                                <small>Último mês</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-dashboard bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Consumo Total (kWh)</h5>
                                <h2 class="mb-0">{{ number_format($consumoTotal, 0, ',', '.') }}</h2>
                                <small>Este mês</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-dashboard bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Faturas Pendentes</h5>
                                <h2 class="mb-0">{{ $faturasPendentes }}</h2>
                                <small>Necessitam atenção</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <h5 class="card-title">Consumo por Mês</h5>
                                <div class="chart-container">
                                    <canvas id="consumoChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <h5 class="card-title">Distribuição de Consumo</h5>
                                <div class="chart-container">
                                    <canvas id="distribuicaoChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Últimas Faturas -->
                <div class="card card-dashboard">
                    <div class="card-body">
                        <h5 class="card-title">Últimas Faturas</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Nº Fatura</th>
                                        <th>Valor</th>
                                        <th>Vencimento</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimasFaturas as $fatura)
                                    <tr>
                                        <td>{{ $fatura->cliente_nome }}</td>
                                        <td>{{ $fatura->numero }}</td>
                                        <td>R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                                        <td>{{ date('d/m/Y', strtotime($fatura->vencimento)) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $fatura->status_cor }}">
                                                {{ $fatura->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-sm btn-success"><i class="fas fa-print"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dados para o gráfico de consumo
        const consumoData = {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Consumo Mensal (kWh)',
                data: {!! json_encode($dadosConsumo) !!},
                borderColor: '#2ecc71',
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                fill: true
            }]
        };

        // Configuração do gráfico de consumo
        new Chart(document.getElementById('consumoChart'), {
            type: 'line',
            data: consumoData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Dados para o gráfico de distribuição
        const distribuicaoData = {
            labels: ['Residencial', 'Comercial', 'Industrial'],
            datasets: [{
                data: {!! json_encode($dadosDistribuicao) !!},
                backgroundColor: ['#3498db', '#e74c3c', '#f1c40f']
            }]
        };

        // Configuração do gráfico de distribuição
        new Chart(document.getElementById('distribuicaoChart'), {
            type: 'doughnut',
            data: distribuicaoData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
