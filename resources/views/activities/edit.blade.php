@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="bi bi-pencil-square mr-2 text-primary-600"></i>
            Editar Actividad
        </h1>
        <a href="{{ route('activities.show', $activity) }}" class="btn-outline">
            <i class="bi bi-arrow-left mr-2"></i>
            Volver a detalles
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Formulario de Edición</h2>
            <span class="badge {{ $activity->estado === 'Realizada' ? 'badge-success' : 
                      ($activity->estado === 'En seguimiento' ? 'badge-warning' : 'badge-info') }}">
                <i class="bi {{ $activity->estado === 'Realizada' ? 'bi-check-circle' : 
                    ($activity->estado === 'En seguimiento' ? 'bi-arrow-repeat' : 'bi-hourglass-split') }} mr-1"></i>
                {{ $activity->estado }}
            </span>
        </div>
        <div class="card-body">
            <form action="{{ route('activities.update', $activity) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Fecha de actividad -->
                    <div>
                        <label for="fecha_actividad" class="form-label">Fecha de actividad</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-calendar3 text-gray-400"></i>
                            </div>
                            <input type="date" name="fecha_actividad" id="fecha_actividad" class="form-input pl-10 @error('fecha_actividad') is-invalid @enderror" value="{{ old('fecha_actividad', $activity->fecha_actividad->format('Y-m-d')) }}" required>
                        </div>
                        @error('fecha_actividad')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="form-label">Estado</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-clipboard-check text-gray-400"></i>
                            </div>
                            <select name="estado" id="estado" class="form-select pl-10 @error('estado') is-invalid @enderror" required>
                                <option value="Pendiente" {{ old('estado', $activity->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Realizada" {{ old('estado', $activity->estado) == 'Realizada' ? 'selected' : '' }}>Realizada</option>
                                <option value="En seguimiento" {{ old('estado', $activity->estado) == 'En seguimiento' ? 'selected' : '' }}>En seguimiento</option>
                            </select>
                        </div>
                        @error('estado')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Prioridad -->
                    <div>
                        <label for="prioridad" class="form-label">Prioridad</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-flag text-gray-400"></i>
                            </div>
                            <select name="prioridad" id="prioridad" class="form-select pl-10 @error('prioridad') is-invalid @enderror" required>
                                <option value="Alta" {{ old('prioridad', $activity->prioridad) == 'Alta' ? 'selected' : '' }}>Alta</option>
                                <option value="Media" {{ old('prioridad', $activity->prioridad) == 'Media' ? 'selected' : '' }}>Media</option>
                                <option value="Baja" {{ old('prioridad', $activity->prioridad) == 'Baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                        </div>
                        @error('prioridad')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="form-label">Descripción</label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 pointer-events-none">
                            <i class="bi bi-card-text text-gray-400"></i>
                        </div>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-textarea pl-10 @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $activity->descripcion) }}</textarea>
                    </div>
                    @error('descripcion')
                        <span class="text-danger-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Observaciones -->
                <div>
                    <h3 class="text-md font-medium text-gray-700 mb-3">Observaciones</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="observacion_general" class="form-label">Observación general</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="bi bi-info-circle text-gray-400"></i>
                                </div>
                                <textarea name="observacion_general" id="observacion_general" rows="4" class="form-textarea pl-10 @error('observacion_general') is-invalid @enderror">{{ old('observacion_general', $activity->observacion_general) }}</textarea>
                            </div>
                            @error('observacion_general')
                                <span class="text-danger-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="observacion_docente" class="form-label">Observación para docente</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="bi bi-mortarboard text-gray-400"></i>
                                </div>
                                <textarea name="observacion_docente" id="observacion_docente" rows="4" class="form-textarea pl-10 @error('observacion_docente') is-invalid @enderror">{{ old('observacion_docente', $activity->observacion_docente) }}</textarea>
                            </div>
                            @error('observacion_docente')
                                <span class="text-danger-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="observacion_otros" class="form-label">Observación para otros</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="bi bi-people text-gray-400"></i>
                                </div>
                                <textarea name="observacion_otros" id="observacion_otros" rows="4" class="form-textarea pl-10 @error('observacion_otros') is-invalid @enderror">{{ old('observacion_otros', $activity->observacion_otros) }}</textarea>
                            </div>
                            @error('observacion_otros')
                                <span class="text-danger-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('activities.show', $activity) }}" class="btn-outline">
                        <i class="bi bi-x-circle mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check2-circle mr-2"></i>
                        Actualizar Actividad
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
