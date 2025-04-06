@extends('layouts.app')

@section('styles')
<style>
    .field-section {
        transition: all 0.3s ease;
    }
    .field-section:hover {
        background-color: #f9fafb;
        border-radius: 0.5rem;
    }
    .toggle-section {
        cursor: pointer;
    }
    .priority-selector input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .priority-selector label {
        cursor: pointer;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }
    .priority-selector input[type="radio"]:checked + label {
        color: white;
    }
    .priority-selector input[type="radio"][value="Alta"]:checked + label {
        background-color: #ef4444;
    }
    .priority-selector input[type="radio"][value="Media"]:checked + label {
        background-color: #f59e0b;
    }
    .priority-selector input[type="radio"][value="Baja"]:checked + label {
        background-color: #10b981;
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="bi bi-plus-circle mr-2 text-primary-600"></i>
            Nueva Actividad
        </h1>
        <a href="{{ route('activities.index') }}" class="btn-outline">
            <i class="bi bi-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('activities.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Campos principales -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Descripción - Campo principal y más visible -->
                    <div class="md:col-span-3">
                        <label for="descripcion" class="form-label">Descripción de la actividad <span class="text-danger-500">*</span></label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 pointer-events-none">
                                <i class="bi bi-card-text text-gray-400"></i>
                            </div>
                            <textarea name="descripcion" id="descripcion" rows="2" class="form-textarea pl-10 @error('descripcion') is-invalid @enderror" required placeholder="Describe brevemente la actividad a realizar...">{{ old('descripcion') }}</textarea>
                        </div>
                        @error('descripcion')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Fecha de actividad - Preseleccionada hoy -->
                    <div>
                        <label for="fecha_actividad" class="form-label">Fecha <span class="text-danger-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-calendar3 text-gray-400"></i>
                            </div>
                            <input type="date" name="fecha_actividad" id="fecha_actividad" class="form-input pl-10 @error('fecha_actividad') is-invalid @enderror" value="{{ old('fecha_actividad', date('Y-m-d')) }}" required>
                        </div>
                        @error('fecha_actividad')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Prioridad - Selector visual -->
                    <div>
                        <label class="form-label">Prioridad <span class="text-danger-500">*</span></label>
                        <div class="priority-selector flex space-x-2 mt-1">
                            <div>
                                <input type="radio" name="prioridad" id="prioridad_alta" value="Alta" {{ old('prioridad') == 'Alta' ? 'checked' : '' }}>
                                <label for="prioridad_alta" class="border border-danger-500 text-danger-500 hover:bg-danger-50">
                                    <i class="bi bi-arrow-up-circle mr-1"></i>Alta
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="prioridad" id="prioridad_media" value="Media" {{ old('prioridad', 'Media') == 'Media' ? 'checked' : '' }}>
                                <label for="prioridad_media" class="border border-warning-500 text-warning-500 hover:bg-warning-50">
                                    <i class="bi bi-dash-circle mr-1"></i>Media
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="prioridad" id="prioridad_baja" value="Baja" {{ old('prioridad') == 'Baja' ? 'checked' : '' }}>
                                <label for="prioridad_baja" class="border border-success-500 text-success-500 hover:bg-success-50">
                                    <i class="bi bi-arrow-down-circle mr-1"></i>Baja
                                </label>
                            </div>
                        </div>
                        @error('prioridad')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Estado - Selector simplificado -->
                    <div>
                        <label class="form-label">Estado <span class="text-danger-500">*</span></label>
                        <div class="flex space-x-2 mt-1">
                            <button type="button" class="flex-1 py-2 px-3 border border-primary-500 rounded-md text-primary-600 text-sm font-medium hover:bg-primary-50 focus:outline-none estado-btn active" data-value="Pendiente">
                                <i class="bi bi-hourglass mr-1"></i>Pendiente
                            </button>
                            <button type="button" class="flex-1 py-2 px-3 border border-warning-500 rounded-md text-warning-600 text-sm font-medium hover:bg-warning-50 focus:outline-none estado-btn" data-value="En seguimiento">
                                <i class="bi bi-arrow-repeat mr-1"></i>Seguimiento
                            </button>
                            <button type="button" class="flex-1 py-2 px-3 border border-success-500 rounded-md text-success-600 text-sm font-medium hover:bg-success-50 focus:outline-none estado-btn" data-value="Realizada">
                                <i class="bi bi-check-circle mr-1"></i>Realizada
                            </button>
                            <input type="hidden" name="estado" id="estado" value="{{ old('estado', 'Pendiente') }}">
                        </div>
                        @error('estado')
                            <span class="text-danger-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Sección de observaciones (colapsable) -->
                <div class="mt-8">
                    <div class="toggle-section flex items-center space-x-2 mb-4" id="toggle-observations">
                        <i class="bi bi-chevron-down text-gray-500"></i>
                        <h3 class="text-md font-medium text-gray-700">Observaciones adicionales (opcional)</h3>
                    </div>
                    
                    <div id="observaciones-section" class="grid grid-cols-1 md:grid-cols-3 gap-6 hidden">
                        <div class="field-section p-3">
                            <label for="observacion_general" class="form-label">Observación general</label>
                            <div class="relative">
                                <textarea name="observacion_general" id="observacion_general" rows="3" class="form-textarea @error('observacion_general') is-invalid @enderror" placeholder="Observaciones generales sobre la actividad...">{{ old('observacion_general') }}</textarea>
                            </div>
                            @error('observacion_general')
                                <span class="text-danger-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="field-section p-3">
                            <label for="observacion_docente" class="form-label">Observación para docente</label>
                            <div class="relative">
                                <textarea name="observacion_docente" id="observacion_docente" rows="3" class="form-textarea @error('observacion_docente') is-invalid @enderror" placeholder="Instrucciones específicas para docentes...">{{ old('observacion_docente') }}</textarea>
                            </div>
                            @error('observacion_docente')
                                <span class="text-danger-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="field-section p-3">
                            <label for="observacion_otros" class="form-label">Observación para otros</label>
                            <div class="relative">
                                <textarea name="observacion_otros" id="observacion_otros" rows="3" class="form-textarea @error('observacion_otros') is-invalid @enderror" placeholder="Instrucciones para otros involucrados...">{{ old('observacion_otros') }}</textarea>
                            </div>
                            @error('observacion_otros')
                                <span class="text-danger-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <button type="button" id="btn-add-template" class="text-primary-600 hover:text-primary-700">
                        <i class="bi bi-lightning-charge mr-1"></i>
                        Usar plantilla
                    </button>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('activities.index') }}" class="btn-outline">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-check-lg mr-2"></i>
                            Crear Actividad
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Plantillas rápidas (modal) -->
<div id="templates-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg max-w-2xl w-full mx-4 shadow-xl">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium">Plantillas rápidas</h3>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button type="button" class="template-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-description="Reunión con el equipo docente para discutir el progreso académico" data-priority="Media">
                    <div class="font-medium">Reunión con docentes</div>
                    <div class="text-gray-500 text-sm mt-1">Reunión para discusión de progreso</div>
                </button>
                
                <button type="button" class="template-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-description="Supervisión de clases y metodologías de enseñanza" data-priority="Alta">
                    <div class="font-medium">Supervisión de clases</div>
                    <div class="text-gray-500 text-sm mt-1">Evaluar metodologías de enseñanza</div>
                </button>
                
                <button type="button" class="template-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-description="Entrega de informes de evaluación trimestral" data-priority="Alta">
                    <div class="font-medium">Entrega de informes</div>
                    <div class="text-gray-500 text-sm mt-1">Evaluación trimestral</div>
                </button>
                
                <button type="button" class="template-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-description="Preparación de materiales didácticos para el próximo periodo" data-priority="Media">
                    <div class="font-medium">Materiales didácticos</div>
                    <div class="text-gray-500 text-sm mt-1">Preparación para próximo periodo</div>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle para mostrar/ocultar observaciones
        const toggleBtn = document.getElementById('toggle-observations');
        const observacionesSection = document.getElementById('observaciones-section');
        
        toggleBtn.addEventListener('click', function() {
            const isHidden = observacionesSection.classList.contains('hidden');
            observacionesSection.classList.toggle('hidden');
            
            // Cambiar el icono
            const icon = toggleBtn.querySelector('i');
            icon.classList.toggle('bi-chevron-down');
            icon.classList.toggle('bi-chevron-up');
        });
        
        // Estado seleccionable con botones
        const estadoBtns = document.querySelectorAll('.estado-btn');
        const estadoInput = document.getElementById('estado');
        
        estadoBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Quitar estado activo de todos los botones
                estadoBtns.forEach(b => b.classList.remove('active', 'bg-primary-100', 'bg-warning-100', 'bg-success-100'));
                
                // Añadir estado activo al botón seleccionado
                this.classList.add('active');
                
                // Añadir estilo según el estado
                if (this.dataset.value === 'Pendiente') {
                    this.classList.add('bg-primary-100');
                } else if (this.dataset.value === 'En seguimiento') {
                    this.classList.add('bg-warning-100');
                } else {
                    this.classList.add('bg-success-100');
                }
                
                // Actualizar el valor del input hidden
                estadoInput.value = this.dataset.value;
            });
            
            // Inicializar el botón activo según el valor del input
            if (btn.dataset.value === estadoInput.value) {
                btn.classList.add('active');
                
                if (btn.dataset.value === 'Pendiente') {
                    btn.classList.add('bg-primary-100');
                } else if (btn.dataset.value === 'En seguimiento') {
                    btn.classList.add('bg-warning-100');
                } else {
                    btn.classList.add('bg-success-100');
                }
            }
        });
        
        // Modal de plantillas rápidas
        const btnAddTemplate = document.getElementById('btn-add-template');
        const templatesModal = document.getElementById('templates-modal');
        const closeModal = document.getElementById('close-modal');
        const templateBtns = document.querySelectorAll('.template-btn');
        const descripcionInput = document.getElementById('descripcion');
        
        btnAddTemplate.addEventListener('click', function() {
            templatesModal.classList.remove('hidden');
        });
        
        closeModal.addEventListener('click', function() {
            templatesModal.classList.add('hidden');
        });
        
        // Al hacer clic fuera del modal, cerrarlo
        templatesModal.addEventListener('click', function(e) {
            if (e.target === templatesModal) {
                templatesModal.classList.add('hidden');
            }
        });
        
        // Usar plantillas
        templateBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const description = this.dataset.description;
                const priority = this.dataset.priority;
                
                // Llenar descripción
                descripcionInput.value = description;
                
                // Seleccionar prioridad
                document.querySelector(`#prioridad_${priority.toLowerCase()}`).checked = true;
                
                // Cerrar modal
                templatesModal.classList.add('hidden');
            });
        });
    });
</script>
@endsection
