@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="bi bi-list-check mr-2 text-primary-600"></i>
            Actividades
        </h1>
        <a href="{{ route('activities.create') }}" class="btn-primary">
            <i class="bi bi-plus mr-2"></i>
            Nueva Actividad
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="bi bi-funnel mr-2 text-primary-600"></i>
                Filtros
            </h2>
            <button type="button" class="text-gray-500 hover:text-gray-700" data-toggle="collapse" data-target="#filterCollapse" aria-expanded="false">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="card-body" id="filterCollapse">
            <form action="{{ route('activities.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="form-label">Buscar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" class="form-input pl-10" value="{{ request('search') }}" placeholder="Descripción...">
                        </div>
                    </div>
                    <div>
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-calendar3 text-gray-400"></i>
                            </div>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-input pl-10" value="{{ request('fecha_inicio') }}">
                        </div>
                    </div>
                    <div>
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-calendar3 text-gray-400"></i>
                            </div>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-input pl-10" value="{{ request('fecha_fin') }}">
                        </div>
                    </div>
                    <div>
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En seguimiento" {{ request('estado') == 'En seguimiento' ? 'selected' : '' }}>En seguimiento</option>
                            <option value="Realizada" {{ request('estado') == 'Realizada' ? 'selected' : '' }}>Realizada</option>
                        </select>
                    </div>
                    <div>
                        <label for="prioridad" class="form-label">Prioridad</label>
                        <select name="prioridad" id="prioridad" class="form-select">
                            <option value="">Todas</option>
                            <option value="Alta" {{ request('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                            <option value="Media" {{ request('prioridad') == 'Media' ? 'selected' : '' }}>Media</option>
                            <option value="Baja" {{ request('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('activities.index') }}" class="btn-outline">
                        <i class="bi bi-x mr-2"></i>
                        Limpiar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-funnel mr-2"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export options -->
    <div class="flex justify-end space-x-3">
        <a href="{{ route('activities.exportPdf') }}?{{ http_build_query(request()->all()) }}" class="btn btn-outline" target="_blank">
            <i class="bi bi-file-pdf mr-2 text-danger-600"></i>
            Exportar PDF
        </a>
        <a href="{{ route('activities.exportExcel') }}?{{ http_build_query(request()->all()) }}" class="btn btn-outline">
            <i class="bi bi-file-excel mr-2 text-success-600"></i>
            Exportar Excel
        </a>
    </div>

    <!-- Activities List -->
    <div class="card">
        <div class="card-body">
            @if($activities->isEmpty())
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="bi bi-clipboard text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No hay actividades</h3>
                    <p class="mt-1 text-gray-500">Comienza creando una nueva actividad.</p>
                    <div class="mt-6">
                        <a href="{{ route('activities.create') }}" class="btn-primary">
                            <i class="bi bi-plus mr-2"></i>
                            Nueva Actividad
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-hover">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripción
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prioridad
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($activities as $activity)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ Str::limit($activity->descripcion, 50) }}
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <i class="bi bi-person mr-1"></i>
                                            {{ $activity->responsable->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge {{ $activity->estado === 'Realizada' ? 'badge-success' : 
                                              ($activity->estado === 'En seguimiento' ? 'badge-warning' : 'badge-info') }}">
                                            <i class="bi {{ $activity->estado === 'Realizada' ? 'bi-check-circle' : 
                                                ($activity->estado === 'En seguimiento' ? 'bi-arrow-repeat' : 'bi-hourglass-split') }} mr-1"></i>
                                            {{ $activity->estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge {{ $activity->prioridad === 'Alta' ? 'badge-danger' : 
                                              ($activity->prioridad === 'Media' ? 'badge-warning' : 'badge-success') }}">
                                            <i class="bi {{ $activity->prioridad === 'Alta' ? 'bi-arrow-up' : 
                                                ($activity->prioridad === 'Media' ? 'bi-dash' : 'bi-arrow-down') }} mr-1"></i>
                                            {{ $activity->prioridad }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="bi bi-calendar3 mr-2"></i>
                                            {{ $activity->fecha_actividad->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('activities.show', $activity) }}" class="text-primary-600 hover:text-primary-900" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('activities.edit', $activity) }}" class="text-secondary-600 hover:text-secondary-900" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger-600 hover:text-danger-900" title="Eliminar"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta actividad?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle para los filtros
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector('[data-toggle="collapse"]');
        const targetElement = document.getElementById(toggleButton.getAttribute('data-target').replace('#', ''));
        
        toggleButton.addEventListener('click', function() {
            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
            toggleButton.setAttribute('aria-expanded', !isExpanded);
            targetElement.style.display = isExpanded ? 'none' : 'block';
            toggleButton.querySelector('i').classList.toggle('bi-chevron-down');
            toggleButton.querySelector('i').classList.toggle('bi-chevron-up');
        });
    });
</script>
@endsection
