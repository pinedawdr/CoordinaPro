@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="bi bi-clipboard-check mr-2 text-primary-600"></i>
            Detalles de la Actividad
        </h1>
        <div class="flex space-x-3">
            <a href="{{ route('activities.edit', $activity) }}" class="btn-secondary">
                <i class="bi bi-pencil mr-2"></i>
                Editar
            </a>
            <a href="{{ route('activities.index') }}" class="btn-outline">
                <i class="bi bi-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <!-- Activity Details -->
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="card-title">Información de la Actividad</h2>
            <span class="badge {{ $activity->estado === 'Realizada' ? 'badge-success' : 
                ($activity->estado === 'En seguimiento' ? 'badge-warning' : 'badge-info') }}">
                <i class="bi {{ $activity->estado === 'Realizada' ? 'bi-check-circle' : 
                    ($activity->estado === 'En seguimiento' ? 'bi-arrow-repeat' : 'bi-hourglass-split') }} mr-1"></i>
                {{ $activity->estado }}
            </span>
        </div>
        
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">INFORMACIÓN BÁSICA</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-gray-500">Fecha de registro</div>
                                <div class="text-sm font-medium flex items-center mt-1">
                                    <i class="bi bi-calendar2-plus mr-2 text-primary-600"></i>
                                    {{ $activity->fecha_actual->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Fecha de actividad</div>
                                <div class="text-sm font-medium flex items-center mt-1">
                                    <i class="bi bi-calendar2-event mr-2 text-primary-600"></i>
                                    {{ $activity->fecha_actividad->format('d/m/Y') }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Responsable</div>
                                <div class="text-sm font-medium flex items-center mt-1">
                                    <i class="bi bi-person mr-2 text-primary-600"></i>
                                    {{ $activity->responsable->name }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Prioridad</div>
                                <div class="text-sm font-medium mt-1">
                                    <span class="badge {{ $activity->prioridad === 'Alta' ? 'badge-danger' : 
                                        ($activity->prioridad === 'Media' ? 'badge-warning' : 'badge-success') }}">
                                        <i class="bi {{ $activity->prioridad === 'Alta' ? 'bi-arrow-up' : 
                                            ($activity->prioridad === 'Media' ? 'bi-dash' : 'bi-arrow-down') }} mr-1"></i>
                                        {{ $activity->prioridad }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">ACCIONES RÁPIDAS</h3>
                        
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-outline">
                                <i class="bi bi-pencil mr-1"></i>
                                Editar
                            </a>
                            
                            <!-- Botón para cambiar el estado a "Realizada" -->
                            @if($activity->estado !== 'Realizada')
                                <form action="{{ route('activities.update', $activity) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="fecha_actividad" value="{{ $activity->fecha_actividad->format('Y-m-d') }}">
                                    <input type="hidden" name="descripcion" value="{{ $activity->descripcion }}">
                                    <input type="hidden" name="observacion_general" value="{{ $activity->observacion_general }}">
                                    <input type="hidden" name="observacion_docente" value="{{ $activity->observacion_docente }}">
                                    <input type="hidden" name="observacion_otros" value="{{ $activity->observacion_otros }}">
                                    <input type="hidden" name="prioridad" value="{{ $activity->prioridad }}">
                                    <input type="hidden" name="estado" value="Realizada">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle mr-1"></i>
                                        Marcar como realizada
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 h-full">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">DESCRIPCIÓN</h3>
                        <div class="prose prose-sm max-w-none text-gray-800">
                            <p class="whitespace-pre-line">{{ $activity->descripcion }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <h3 class="text-lg font-semibold mb-4 text-gray-900">Observaciones</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 flex items-center mb-3">
                        <i class="bi bi-info-circle mr-2 text-primary-600"></i>
                        Observación General
                    </h4>
                    <p class="whitespace-pre-line text-sm text-gray-800">
                        {{ $activity->observacion_general ?? 'No hay observaciones' }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 flex items-center mb-3">
                        <i class="bi bi-mortarboard mr-2 text-primary-600"></i>
                        Observación para Docente
                    </h4>
                    <p class="whitespace-pre-line text-sm text-gray-800">
                        {{ $activity->observacion_docente ?? 'No hay observaciones' }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 flex items-center mb-3">
                        <i class="bi bi-people mr-2 text-primary-600"></i>
                        Observación para Otros
                    </h4>
                    <p class="whitespace-pre-line text-sm text-gray-800">
                        {{ $activity->observacion_otros ?? 'No hay observaciones' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end">
        <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta actividad?')">
                <i class="bi bi-trash mr-2"></i>
                Eliminar Actividad
            </button>
        </form>
    </div>
</div>
@endsection
