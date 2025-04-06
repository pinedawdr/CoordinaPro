@extends('layouts.app')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="bi bi-speedometer2 mr-2 text-primary-600"></i>
            Panel de Control
        </h1>
        <span class="text-gray-500">{{ now()->format('d/m/Y') }}</span>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Pending activities -->
        <div class="card bg-gradient-to-br from-primary-50 to-primary-100 border-l-4 border-primary-500">
            <div class="card-body flex items-center">
                <div class="rounded-full bg-primary-100 p-3 mr-4">
                    <i class="bi bi-hourglass text-2xl text-primary-600"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pendientes }}</div>
                    <div class="text-sm font-medium text-gray-500">Actividades pendientes</div>
                </div>
            </div>
        </div>

        <!-- In progress activities -->
        <div class="card bg-gradient-to-br from-warning-50 to-warning-100 border-l-4 border-warning-500">
            <div class="card-body flex items-center">
                <div class="rounded-full bg-warning-100 p-3 mr-4">
                    <i class="bi bi-arrow-repeat text-2xl text-warning-600"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $enSeguimiento }}</div>
                    <div class="text-sm font-medium text-gray-500">En seguimiento</div>
                </div>
            </div>
        </div>

        <!-- Completed activities -->
        <div class="card bg-gradient-to-br from-success-50 to-success-100 border-l-4 border-success-500">
            <div class="card-body flex items-center">
                <div class="rounded-full bg-success-100 p-3 mr-4">
                    <i class="bi bi-check-circle text-2xl text-success-600"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $realizadas }}</div>
                    <div class="text-sm font-medium text-gray-500">Actividades realizadas</div>
                </div>
            </div>
        </div>

        <!-- Total activities -->
        <div class="card bg-gradient-to-br from-secondary-50 to-secondary-100 border-l-4 border-secondary-500">
            <div class="card-body flex items-center">
                <div class="rounded-full bg-secondary-100 p-3 mr-4">
                    <i class="bi bi-clipboard-data text-2xl text-secondary-600"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pendientes + $enSeguimiento + $realizadas }}</div>
                    <div class="text-sm font-medium text-gray-500">Total actividades</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and upcoming activities -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Monthly chart -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-bar-chart-line mr-2 text-primary-600"></i>
                    Actividades por mes
                </h2>
                <span class="text-sm text-gray-500">Últimos 12 meses</span>
            </div>
            <div class="card-body">
                <canvas id="activitiesChart" height="200"></canvas>
            </div>
        </div>

        <!-- Upcoming activities -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-calendar-check mr-2 text-primary-600"></i>
                    Próximas actividades
                </h2>
                <a href="{{ route('activities.calendar') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium flex items-center">
                    Ver calendario
                    <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="card-body">
                @if($proximas->isEmpty())
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center p-4 bg-gray-100 rounded-full mb-4">
                            <i class="bi bi-calendar-x text-3xl text-gray-500"></i>
                        </div>
                        <p class="text-gray-500">No hay actividades programadas para los próximos 7 días.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($proximas as $actividad)
                            <li class="py-3 hover:bg-gray-50 rounded-lg px-2 transition-colors duration-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="badge {{ $actividad->prioridad === 'Alta' ? 'badge-danger' : 
                                            ($actividad->prioridad === 'Media' ? 'badge-warning' : 'badge-success') }}">
                                            {{ $actividad->prioridad }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('activities.show', $actividad) }}" class="hover:text-primary-600">
                                                {{ Str::limit($actividad->descripcion, 50) }}
                                            </a>
                                        </p>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <i class="bi bi-calendar2-event mr-1"></i>
                                            {{ $actividad->fecha_actividad->format('d/m/Y') }}
                                            
                                            <span class="mx-2">•</span>
                                            
                                            <span class="badge {{ $actividad->estado === 'Realizada' ? 'badge-success' : 
                                                ($actividad->estado === 'En seguimiento' ? 'badge-warning' : 'badge-info') }}">
                                                {{ $actividad->estado }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="{{ route('activities.index') }}" class="text-primary-600 hover:text-primary-700 font-medium flex items-center justify-center">
                            Ver todas las actividades
                            <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick access -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-lightning-charge mr-2 text-primary-600"></i>
                Acciones rápidas
            </h2>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('activities.create') }}" class="card bg-gradient-to-br from-primary-50 to-primary-100 block text-center py-6 hover:shadow-hover transition-all duration-300 transform hover:-translate-y-1">
                    <i class="bi bi-plus-circle text-4xl text-primary-600 mb-3"></i>
                    <div class="text-gray-900 font-medium">Nueva Actividad</div>
                </a>
                <a href="{{ route('activities.calendar') }}" class="card bg-gradient-to-br from-secondary-50 to-secondary-100 block text-center py-6 hover:shadow-hover transition-all duration-300 transform hover:-translate-y-1">
                    <i class="bi bi-calendar-week text-4xl text-secondary-600 mb-3"></i>
                    <div class="text-gray-900 font-medium">Calendario</div>
                </a>
                <a href="{{ route('activities.exportPdf') }}" class="card bg-gradient-to-br from-success-50 to-success-100 block text-center py-6 hover:shadow-hover transition-all duration-300 transform hover:-translate-y-1">
                    <i class="bi bi-file-earmark-pdf text-4xl text-success-600 mb-3"></i>
                    <div class="text-gray-900 font-medium">Generar Reporte</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activitiesChart').getContext('2d');
        
        // Definir colores modernos para el gráfico
        const primaryColor = 'rgba(99, 102, 241, 0.8)';
        const primaryColorBorder = 'rgba(79, 70, 229, 1)';
        
        const activitiesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($meses),
                datasets: [{
                    label: 'Actividades',
                    data: @json($totales),
                    backgroundColor: primaryColor,
                    borderColor: primaryColorBorder,
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 35
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#6B7280',
                        bodyColor: '#111827',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        cornerRadius: 8,
                        boxPadding: 6,
                        usePointStyle: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#6B7280'
                        },
                        grid: {
                            color: '#F3F4F6'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#6B7280'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
