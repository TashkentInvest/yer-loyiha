@extends('layouts.admin')

@section('title', 'Бошқарув панели')

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4">Тошкент Инвест бошқарув панели</h1>

        <!-- Фильтрлар -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-filter me-1"></i> Вақт оралиғи бўйича фильтрлаш</div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Бошланғич сана</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Якуний сана</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Қўллаш</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Асосий статистика -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Жами объектлар</div>
                                <div class="h2">{{ number_format($totalAktivs) }}</div>
                            </div>
                            <div><i class="fas fa-building fa-3x opacity-50"></i></div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small">
                            @if ($aktivsGrowth > 0)
                                <i class="fas fa-arrow-up me-1"></i> {{ number_format($aktivsGrowth, 1) }}% ўсиш
                            @elseif($aktivsGrowth < 0)
                                <i class="fas fa-arrow-down me-1"></i> {{ number_format(abs($aktivsGrowth), 1) }}% камайиш
                            @else
                                <i class="fas fa-equals me-1"></i> Ўзгаришсиз
                            @endif
                            ўтган йилга нисбатан
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Жами ер майдони</div>
                                <div class="h2">{{ number_format($totalLandArea, 1) }} га</div>
                            </div>
                            <div><i class="fas fa-map fa-3x opacity-50"></i></div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small">{{ number_format($totalBuildingArea) }} м² умумий бино майдони</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Жами инвестициялар</div>
                                <div class="h2">{{ number_format($totalInvestmentAmount / 1000000, 1) }} млн</div>
                            </div>
                            <div><i class="fas fa-money-bill-wave fa-3x opacity-50"></i></div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small">Ўртача {{ number_format($avgInvestmentAmount / 1000000, 1) }} млн сўм ҳар бир
                            объектга</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Яратилган иш ўринлари</div>
                                <div class="h2">{{ number_format($totalJobCreation) }}</div>
                            </div>
                            <div><i class="fas fa-users fa-3x opacity-50"></i></div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="small">Ўртача {{ number_format($avgJobCreation, 1) }} иш ўрини ҳар бир объектга</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Графиклар -->
        <div class="row">
            <!-- Ойлик ҳисобот графиги -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Янги объектлар статистикаси (охирги 12 ой)
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyStatsChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>

            <!-- Бино тури бўйича статистика графиги -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Бино тури бўйича статистика
                    </div>
                    <div class="card-body">
                        <canvas id="buildingTypeChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Ер майдони бўйича статистика -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Ер майдони бўйича тақсимланиш
                    </div>
                    <div class="card-body">
                        <canvas id="landAreaChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>

            <!-- Коммуникациялар статистикаси -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-bolt me-1"></i>
                        Коммуникациялар мавжудлиги
                    </div>
                    <div class="card-body">
                        <canvas id="utilitiesChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Янги қўшилган объектлар -->
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Сўнги қўшилган объектлар
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Объект номи</th>
                                        <th>Ер майдони</th>
                                        <th>Ҳудуд</th>
                                        <th>Қўшилди</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentActivities as $aktiv)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('aktivs.show', $aktiv->id) }}">{{ $aktiv->object_name }}</a>
                                            </td>
                                            <td>{{ $aktiv->land_area }} га</td>
                                            <td>{{ $aktiv->location }}</td>
                                            <td>{{ $aktiv->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Танланган даврда маълумот мавжуд эмас
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('aktivs.index') }}" class="btn btn-primary btn-sm">Барча объектларни кўриш</a>
                    </div>
                </div>
            </div>

            <!-- Топ зоналар -->
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-map-marked-alt me-1"></i>
                        Зоналар бўйича статистика (Топ-5)
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @forelse($topZones as $zone)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $zone->zone }}
                                    <span class="badge bg-primary rounded-pill">{{ $zone->total }}</span>
                                </div>
                            @empty
                                <div class="list-group-item">Маълумот топилмади</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Кўчалар бўйича статистика -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-road me-1"></i>
                        Кўчалар бўйича статистика (Топ-5)
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @forelse($streetStats as $street)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $street->name }}
                                    <span class="badge bg-success rounded-pill">{{ $street->aktivs_count }}</span>
                                </div>
                            @empty
                                <div class="list-group-item">Маълумот топилмади</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ойлик статистика графиги
            const monthlyStatsChart = new Chart(document.getElementById('monthlyStatsChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($monthlyStats)) !!},
                    datasets: [{
                        label: 'Янги объектлар',
                        data: {!! json_encode(array_values($monthlyStats)) !!},
                        fill: true,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });


            // Ер майдони бўйича статистика графиги
            const landAreaChart = new Chart(document.getElementById('landAreaChart'), {
                type: 'bar',
                data: {
                    labels: ['0-0.1 га', '0.1-1 га', '1-10 га', '10+ га'],
                    datasets: [{
                        label: 'Объектлар сони',
                        data: {!! json_encode(array_values($landAreaStats)) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Коммуникациялар статистикаси графиги
            const utilitiesData = {
                labels: ['Мавжуд', 'Мавжуд эмас'],
                datasets: [{
                        label: 'Газ таъминоти',
                        data: [
                            {{ $utilitiesStats['Газ таъминоти']['Мавжуд'] }},
                            {{ $utilitiesStats['Газ таъминоти']['Мавжуд эмас'] }}
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.5)'
                    },
                    {
                        label: 'Сув таъминоти',
                        data: [
                            {{ $utilitiesStats['Сув таъминоти']['Мавжуд'] }},
                            {{ $utilitiesStats['Сув таъминоти']['Мавжуд эмас'] }}
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    },
                    {
                        label: 'Электр таъминоти',
                        data: [
                            {{ $utilitiesStats['Электр таъминоти']['Мавжуд'] }},
                            {{ $utilitiesStats['Электр таъминоти']['Мавжуд эмас'] }}
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.5)'
                    }
                ]
            };

            const utilitiesChart = new Chart(document.getElementById('utilitiesChart'), {
                type: 'bar',
                data: utilitiesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
