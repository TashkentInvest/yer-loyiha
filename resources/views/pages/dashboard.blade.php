@extends('layouts.admin')

@section('title', 'Тошкент Инвест | Бошқарув панели')

@section('content')
    <div class="container-fluid px-4">
        <!-- Сарлавҳа ва фильтр сатри -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center my-4">
            <div class="dashboard-header mb-3 mb-md-0">
                <h1 class="mb-1"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Бошқарув панели</h1>
                <p class="text-muted mb-0">Тошкент шаҳри инвестицион объектлари мониторинги</p>
            </div>
            <div class="date-filter-panel">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <div class="input-group input-group-sm date-input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                            <input type="date" class="form-control form-control-sm" name="start_date" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="input-group input-group-sm date-input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                            <input type="date" class="form-control form-control-sm" name="end_date" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-filter me-1"></i> Қўллаш
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Асосий статистика картлари -->
        <div class="row stats-card-row">
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card mb-4 border-start-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-title">Жами объектлар</div>
                                <div class="stats-value">{{ number_format($totalAktivs) }}</div>
                                <div class="stats-trend mt-2">
                                    @if ($aktivsGrowth > 0)
                                        <span class="badge bg-success"><i class="fas fa-arrow-up me-1"></i>{{ number_format($aktivsGrowth, 1) }}%</span>
                                    @elseif($aktivsGrowth < 0)
                                        <span class="badge bg-danger"><i class="fas fa-arrow-down me-1"></i>{{ number_format(abs($aktivsGrowth), 1) }}%</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-equals me-1"></i>0%</span>
                                    @endif
                                    <span class="small text-muted ms-1">ўтган йилга нисбатан</span>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stats-card mb-4 border-start-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-title">Жами ер майдони</div>
                                <div class="stats-value">{{ number_format($totalLandArea, 1) }} <span class="stats-unit">га</span></div>
                                <div class="stats-detail mt-2">
                                    <span class="small text-muted">
                                        <i class="fas fa-ruler-combined text-success me-1"></i>
                                        {{ number_format($totalBuildingArea) }} м² қурилиш майдони
                                    </span>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-map"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stats-card mb-4 border-start-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-title">Жами инвестициялар</div>
                                <div class="stats-value">{{ number_format($totalInvestmentAmount / 1000000, 1) }} <span class="stats-unit">млн</span></div>
                                <div class="stats-detail mt-2">
                                    <span class="small text-muted">
                                        <i class="fas fa-calculator text-warning me-1"></i>
                                        Ўртача: {{ number_format($avgInvestmentAmount / 1000000, 1) }} млн сўм/объект
                                    </span>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stats-card mb-4 border-start-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-title">Яратилган иш ўринлари</div>
                                <div class="stats-value">{{ number_format($totalJobCreation) }}</div>
                                <div class="stats-detail mt-2">
                                    <span class="small text-muted">
                                        <i class="fas fa-user-plus text-info me-1"></i>
                                        Ўртача: {{ number_format($avgJobCreation, 1) }} иш ўрини/объект
                                    </span>
                                </div>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Графиклар -->
        <div class="row">
            <!-- Ойлик ҳисобот графиги -->
            <div class="col-xl-6">
                <div class="card analytics-card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-chart-area text-primary me-1"></i> Янги объектлар динамикаси</div>
                            <div class="chart-period badge bg-light text-dark">Охирги 12 ой</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyStatsChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Ер майдони бўйича статистика -->
            <div class="col-xl-6">
                <div class="card analytics-card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-chart-bar text-primary me-1"></i> Ер майдони бўйича тақсимланиш</div>
                            <div class="chart-legend d-flex">
                                <span class="chart-legend-item"><i class="fas fa-square text-danger"></i> 0-0.1 га</span>
                                <span class="chart-legend-item"><i class="fas fa-square text-primary"></i> 0.1-1 га</span>
                                <span class="chart-legend-item"><i class="fas fa-square text-warning"></i> 1-10 га</span>
                                <span class="chart-legend-item"><i class="fas fa-square text-success"></i> 10+ га</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="landAreaChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Коммуникациялар статистикаси -->
            <div class="col-xl-6">
                <div class="card analytics-card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-bolt text-primary me-1"></i> Коммуникациялар мавжудлиги</div>
                            <div class="utilities-legend d-flex">
                                <span class="utilities-legend-item"><i class="fas fa-circle text-danger"></i> Газ</span>
                                <span class="utilities-legend-item"><i class="fas fa-circle text-primary"></i> Сув</span>
                                <span class="utilities-legend-item"><i class="fas fa-circle text-success"></i> Электр</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="utilitiesChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Зона ва кўчалар статистикаси -->
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header nav-tabs-header p-0">
                        <ul class="nav nav-tabs" id="locationTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="zones-tab" data-bs-toggle="tab" href="#zones" role="tab">
                                    <i class="fas fa-map-marked-alt me-1"></i> Зоналар (Топ-5)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="streets-tab" data-bs-toggle="tab" href="#streets" role="tab">
                                    <i class="fas fa-road me-1"></i> Кўчалар (Топ-5)
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="zones" role="tabpanel">
                                <div class="stats-list">
                                    @forelse($topZones as $index => $zone)
                                        <div class="stats-list-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="stats-rank">{{ $index + 1 }}</span>
                                                <span class="stats-label">{{ $zone->zone }}</span>
                                            </div>
                                            <span class="stats-count badge rounded-pill bg-primary">{{ $zone->total }}</span>
                                        </div>
                                    @empty
                                        <div class="alert alert-light text-center">
                                            <i class="fas fa-info-circle me-2"></i> Маълумот топилмади
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="streets" role="tabpanel">
                                <div class="stats-list">
                                    @forelse($streetStats as $index => $street)
                                        <div class="stats-list-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="stats-rank">{{ $index + 1 }}</span>
                                                <span class="stats-label">{{ $street->name }}</span>
                                            </div>
                                            <span class="stats-count badge rounded-pill bg-success">{{ $street->aktivs_count }}</span>
                                        </div>
                                    @empty
                                        <div class="alert alert-light text-center">
                                            <i class="fas fa-info-circle me-2"></i> Маълумот топилмади
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Янги қўшилган объектлар -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div><i class="fas fa-table text-primary me-1"></i> Сўнги қўшилган объектлар</div>
                    <div class="date-range-badge">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped recent-objects-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Объект номи</th>
                                <th>Ер майдони</th>
                                <th>Ҳудуд</th>
                                <th>Қўшилган сана</th>
                                <th class="text-center">Амаллар</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $index => $aktiv)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('aktivs.show', $aktiv->id) }}" class="object-name">
                                            {{ $aktiv->object_name }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="land-area-badge">
                                            <i class="fas fa-map me-1"></i>
                                            {{ number_format($aktiv->land_area, 2) }} га
                                        </span>
                                    </td>
                                    <td>
                                        <span class="location-text">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            {{ $aktiv->location }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="date-time-text">
                                            <i class="far fa-clock text-muted me-1"></i>
                                            {{ $aktiv->created_at->format('d.m.Y H:i') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('aktivs.show', $aktiv->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('aktivs.edit', $aktiv->id) }}" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="no-data-message">
                                            <i class="fas fa-folder-open text-muted mb-3"></i>
                                            <p>Танланган даврда маълумот мавжуд эмас</p>
                                            <a href="{{ route('aktivs.create') }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus-circle me-1"></i> Янги объект қўшиш
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="small text-muted">Жами {{ $recentActivities->count() }} та объект кўрсатилмоқда</span>
                <a href="{{ route('aktivs.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-list-ul me-1"></i> Барча объектларни кўриш
                </a>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
/* Dashboard Styles */
.dashboard-header h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: #333;
}

.date-filter-panel {
    background: #f8f9fc;
    padding: 10px;
    border-radius: 6px;
}

.date-input-group {
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}

/* Stats Cards */
.stats-card-row {
    margin-bottom: 1.5rem;
}

.stats-card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 0.15rem 1.25rem 0 rgba(58, 59, 69, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.15);
}

.border-start-primary {
    border-left: 4px solid #4e73df !important;
}

.border-start-success {
    border-left: 4px solid #1cc88a !important;
}

.border-start-warning {
    border-left: 4px solid #f6c23e !important;
}

.border-start-info {
    border-left: 4px solid #36b9cc !important;
}

.stats-title {
    color: #5a5c69;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.35rem;
}

.stats-value {
    color: #333;
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 0.3rem;
}

.stats-unit {
    font-size: 1rem;
    color: #666;
    font-weight: 500;
}

.stats-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    font-size: 1.5rem;
}

.border-start-primary .stats-icon {
    color: #4e73df;
    background-color: rgba(78, 115, 223, 0.1);
}

.border-start-success .stats-icon {
    color: #1cc88a;
    background-color: rgba(28, 200, 138, 0.1);
}

.border-start-warning .stats-icon {
    color: #f6c23e;
    background-color: rgba(246, 194, 62, 0.1);
}

.border-start-info .stats-icon {
    color: #36b9cc;
    background-color: rgba(54, 185, 204, 0.1);
}

/* Analytics Cards */
.analytics-card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 0.15rem 1.25rem 0 rgba(58, 59, 69, 0.1);
    margin-bottom: 24px;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    padding: 0.75rem 1.25rem;
    font-weight: 600;
    color: #4e73df;
}

.chart-period {
    font-size: 0.7rem;
    padding: 0.3rem 0.6rem;
}

.chart-legend, .utilities-legend {
    font-size: 0.75rem;
}

.chart-legend-item, .utilities-legend-item {
    margin-left: 10px;
    display: flex;
    align-items: center;
}

.chart-legend-item i, .utilities-legend-item i {
    margin-right: 5px;
    font-size: 0.7rem;
}

/* Tabs Styling */
.nav-tabs-header {
    background-color: #f8f9fc;
}

.nav-tabs {
    border-bottom: 0;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    border-radius: 0;
}

.nav-tabs .nav-link.active {
    color: #4e73df;
    background-color: #fff;
    border-top: 2px solid #4e73df;
}

/* Stats List */
.stats-list {
    margin-top: 10px;
}

.stats-list-item {
    padding: 12px 5px;
    border-bottom: 1px solid #f1f1f1;
}

.stats-list-item:last-child {
    border-bottom: none;
}

.stats-rank {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background-color: #f8f9fc;
    color: #4e73df;
    font-weight: 600;
    margin-right: 12px;
    font-size: 0.85rem;
}

.stats-label {
    font-weight: 500;
}

.stats-count {
    font-size: 0.8rem;
}

/* Recent Objects Table */
.recent-objects-table thead th {
    background-color: #f8f9fc;
    font-weight: 600;
    font-size: 0.9rem;
    border-bottom-width: 1px;
}

.recent-objects-table tbody tr {
    transition: background-color 0.15s;
}

.recent-objects-table tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

.object-name {
    font-weight: 500;
    color: #4e73df;
    text-decoration: none;
}

.land-area-badge {
    display: inline-block;
    padding: 4px 8px;
    background-color: rgba(28, 200, 138, 0.1);
    border-radius: 4px;
    color: #1cc88a;
    font-weight: 500;
    font-size: 0.85rem;
}

.location-text {
    font-size: 0.9rem;
}

.date-time-text {
    font-size: 0.85rem;
    color: #6c757d;
}

.date-range-badge {
    font-size: 0.85rem;
    padding: 4px 10px;
    background-color: #f8f9fc;
    border-radius: 4px;
    border: 1px solid #e3e6f0;
    color: #6c757d;
}

/* No Data Message */
.no-data-message {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #6c757d;
}

.no-data-message i {
    font-size: 3rem;
}

/* Responsive Fixes */
@media (max-width: 768px) {
    .stats-card {
        margin-bottom: 1rem;
    }

    .stats-icon {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 1.2rem;
    }

    .stats-value {
        font-size: 1.5rem;
    }

    .chart-legend, .utilities-legend {
        display: none !important;
    }
}
</style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart color scheme
            const colorPrimary = '#4e73df';
            const colorSuccess = '#1cc88a';
            const colorWarning = '#f6c23e';
            const colorDanger = '#e74a3b';
            const colorInfo = '#36b9cc';

            // Set global Chart.js options
            Chart.defaults.font.family = "'Nunito', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = "#666";
            Chart.defaults.plugins.tooltip.backgroundColor = "rgba(0, 0, 0, 0.7)";
            Chart.defaults.plugins.tooltip.padding = 10;
            Chart.defaults.plugins.tooltip.cornerRadius = 4;

            // Ойлик статистика графиги
            const monthlyStatsChart = new Chart(document.getElementById('monthlyStatsChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($monthlyStats)) !!},
                    datasets: [{
                        label: 'Янги объектлар',
                        data: {!! json_encode(array_values($monthlyStats)) !!},
                        fill: true,
                        borderColor: colorPrimary,
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: colorPrimary,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: colorPrimary,
                        pointHoverBorderColor: "#fff"
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return context[0].label + ' - Янги объектлар';
                                },
                                label: function(context) {
                                    return context.parsed.y + ' та объект';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                callback: function(value) {
                                    return value + ' та';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Объектлар сони'
                            },
                            grid: {
                                drawBorder: false,
                                color: "rgba(0, 0, 0, 0.05)"
                            }
                        },
                        x: {
                            grid: {
                                display: false
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
                            colorDanger,
                            colorPrimary,
                            colorWarning,
                            colorSuccess
                        ],
                        borderWidth: 0,
                        borderRadius: 4,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return context[0].label + ' майдонли объектлар';
                                },
                                label: function(context) {
                                    return context.parsed.y + ' та объект';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                callback: function(value) {
                                    return value + ' та';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Объектлар сони'
                            },
                            grid: {
                                drawBorder: false,
                                color: "rgba(0, 0, 0, 0.05)"
                            }
                        },
                        x: {
                            grid: {
                                display: false
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
                        backgroundColor: colorDanger,
                        barThickness: 25,
                        borderRadius: 4
                    },
                    {
                        label: 'Сув таъминоти',
                        data: [
                            {{ $utilitiesStats['Сув таъминоти']['Мавжуд'] }},
                            {{ $utilitiesStats['Сув таъминоти']['Мавжуд эмас'] }}
                        ],
                        backgroundColor: colorPrimary,
                        barThickness: 25,
                        borderRadius: 4
                    },
                    {
                        label: 'Электр таъминоти',
                        data: [
                            {{ $utilitiesStats['Электр таъминоти']['Мавжуд'] }},
                            {{ $utilitiesStats['Электр таъминоти']['Мавжуд эмас'] }}
                        ],
                        backgroundColor: colorSuccess,
                        barThickness: 25,
                        borderRadius: 4
                    }
                ]
            };

            const utilitiesChart = new Chart(document.getElementById('utilitiesChart'), {
                type: 'bar',
                data: utilitiesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.parsed.y || 0;
                                    return label + ': ' + value + ' та объект';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                callback: function(value) {
                                    return value + ' та';
                                }
                            },
                            grid: {
                                drawBorder: false,
                                color: "rgba(0, 0, 0, 0.05)"
                            }
                        }
                    }
                }
            });

            // Update timestamps every minute
            function updateTimestamp() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeString = hours + ':' + minutes + ':' + seconds;

                // If you have a timestamp element to update
                // document.querySelector('.current-time').textContent = timeString;
            }

            // Update time now and every minute
            updateTimestamp();
            setInterval(updateTimestamp, 60000);
        });
    </script>
@endsection
