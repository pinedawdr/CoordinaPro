@extends('layouts.app')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
<style>
    .fc-header-toolbar {
        margin-bottom: 1.5em !important;
        font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
    }
    
    .fc .fc-button-primary {
        background-color: #1a50f2 !important;
        border-color: #1641e3 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
    }
    
    .fc .fc-button-primary:hover {
        background-color: #1641e3 !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
    }
    
    .fc-event {
        cursor: pointer;
        border-radius: 8px !important;
        padding: 3px 6px !important;
        margin: 2px 0 !important;
        border: none !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .fc-day-today {
        background-color: rgba(26, 80, 242, 0.05) !important;
    }
    
    .fc-day-grid-event .fc-content {
        white-space: normal !important;
        overflow: hidden;
    }
    
    .event-legend {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
        padding: 10px 15px;
        background-color: #f9fafb;
        border-radius: 10px;
        border: 1px solid #eeeeee;
    }
    
    .event-legend-item {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
    }
    
    .event-legend-color {
        width: 12px;
        height: 12px;
        border-radius: 4px;
        margin-right: 6px;
    }
    
    /* Estilos para el modal de detalles */
    .event-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }
    
    .event-modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 24px;
        border: none;
        width: 90%;
        max-width: 600px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        animation: scale 0.3s ease;
    }
    
    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        line-height: 1;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .close-modal:hover {
        color: #333;
    }
    
    .event-detail-header {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
    }
    
    .event-detail-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #222;
        flex-grow: 1;
    }
    
    .event-detail-content {
        margin-bottom: 20px;
    }
    
    .event-detail-label {
        font-weight: 500;
        color: #666;
        margin-bottom: 4px;
    }
    
    .event-detail-value {
        margin-bottom: 12px;
    }
    
    .event-detail-actions {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    /* Estilos para los filtros */
    .calendar-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f9fafb;
        border-radius: 12px;
        border: 1px solid #eee;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .filter-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
    }
    
    /* Estilos para la vista de próximas actividades */
    .upcoming-events {
        margin-top: 20px;
    }
    
    .upcoming-event-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 8px;
        background-color: #ffffff;
        border: 1px solid #eee;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    }
    
    .upcoming-event-item:hover {
        background-color: #f9fafb;
        transform: translateX(5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    
    .upcoming-event-date {
        min-width: 80px;
        text-align: center;
        font-weight: 600;
        color: #1a50f2;
        padding: 6px;
        background-color: #eef6ff;
        border-radius: 6px;
    }
    
    .upcoming-event-title {
        flex-grow: 1;
        margin-left: 15px;
        font-weight: 500;
    }
    
    .upcoming-event-status {
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-pendiente {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    
    .status-en_seguimiento {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .status-realizada {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    /* Estilos para la vista de estadísticas */
    .calendar-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .stat-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
        transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
    }
    
    .stat-title {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 5px;
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111827;
    }
    
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .stat-primary {
        color: #1a50f2;
    }
    
    .stat-success {
        color: #10b981;
    }
    
    .stat-warning {
        color: #f59e0b;
    }
    
    .stat-danger {
        color: #ff2323;
    }
    
    @keyframes scale {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center flex-wrap gap-4">
        <h1 class="text-2xl font-bold text-neutral-900">
            <i class="bi bi-calendar-event mr-2 text-primary-600"></i>
            Calendario de Actividades
        </h1>
        <div class="flex space-x-3">
            <a href="{{ route('activities.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i>
                Nueva Actividad
            </a>
        </div>
    </div>

    <!-- Filtros del calendario -->
    <div class="calendar-filters">
        <div class="filter-group">
            <label for="filter-status" class="filter-label">Estado:</label>
            <select id="filter-status" class="form-select form-select-sm">
                <option value="">Todos</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En seguimiento">En seguimiento</option>
                <option value="Realizada">Realizada</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-priority" class="filter-label">Prioridad:</label>
            <select id="filter-priority" class="form-select form-select-sm">
                <option value="">Todas</option>
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-date-range" class="filter-label">Rango de fechas:</label>
            <select id="filter-date-range" class="form-select form-select-sm">
                <option value="">Todo el tiempo</option>
                <option value="today">Hoy</option>
                <option value="week">Esta semana</option>
                <option value="month">Este mes</option>
                <option value="quarter">Este trimestre</option>
                <option value="year">Este año</option>
            </select>
        </div>
        
        <div class="filter-group">
            <button id="apply-filters" class="btn-primary btn-sm">
                <i class="bi bi-funnel mr-1"></i> Aplicar
            </button>
            <button id="reset-filters" class="btn-outline btn-sm">
                <i class="bi bi-x-circle mr-1"></i> Restablecer
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Calendario principal -->
        <div class="lg:col-span-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Calendario</h2>
                </div>
                <div class="card-body">
                    <div class="event-legend">
                        <div class="event-legend-item">
                            <span class="event-legend-color" style="background-color: #3b82f6;"></span>
                            Pendiente
                        </div>
                        <div class="event-legend-item">
                            <span class="event-legend-color" style="background-color: #f59e0b;"></span>
                            En seguimiento
                        </div>
                        <div class="event-legend-item">
                            <span class="event-legend-color" style="background-color: #10b981;"></span>
                            Realizada
                        </div>
                        <div class="event-legend-item">
                            <span class="event-legend-color" style="border-left: 3px solid #ef4444; background-color: white"></span>
                            Prioridad alta
                        </div>
                    </div>

                    <div id="calendar" style="height: 650px;"></div>
                </div>
            </div>
        </div>
        
        <!-- Panel lateral -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Próximas actividades -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Próximas Actividades</h2>
                </div>
                <div class="card-body">
                    <div id="upcoming-events" class="upcoming-events">
                        <div class="text-center text-gray-500 py-4">
                            <i class="bi bi-arrow-clockwise text-2xl mb-2"></i>
                            <p>Cargando próximas actividades...</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Estadísticas</h2>
                </div>
                <div class="card-body">
                    <div class="calendar-stats">
                        <div class="stat-card">
                            <div class="stat-icon stat-primary">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="stat-title">Total Actividades</div>
                            <div class="stat-value" id="stat-total">0</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon stat-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="stat-title">Realizadas</div>
                            <div class="stat-value" id="stat-completed">0</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon stat-warning">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="stat-title">Pendientes</div>
                            <div class="stat-value" id="stat-pending">0</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon stat-danger">
                                <i class="bi bi-exclamation-circle"></i>
                            </div>
                            <div class="stat-title">Alta Prioridad</div>
                            <div class="stat-value" id="stat-high-priority">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de detalles de actividad -->
<div id="event-modal" class="event-modal">
    <div class="event-modal-content">
        <div class="event-modal-header">
            <h3 class="event-modal-title" id="modal-title">Detalles de la Actividad</h3>
            <span class="event-modal-close" id="modal-close">&times;</span>
        </div>
        <div class="event-modal-body" id="modal-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Fecha</p>
                    <p class="font-medium" id="modal-date">-</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Estado</p>
                    <p class="font-medium" id="modal-status">-</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Prioridad</p>
                    <p class="font-medium" id="modal-priority">-</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Responsable</p>
                    <p class="font-medium" id="modal-responsible">-</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-1">Descripción</p>
                <p class="font-medium" id="modal-description">-</p>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-1">Observaciones</p>
                <p class="font-medium" id="modal-observations">-</p>
            </div>
        </div>
        <div class="event-modal-footer">
            <button id="modal-edit" class="btn-outline">
                <i class="bi bi-pencil mr-1"></i> Editar
            </button>
            <button id="modal-view" class="btn-primary">
                <i class="bi bi-eye mr-1"></i> Ver Detalles
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let calendar;
        let allEvents = @json($events);
        let filteredEvents = [...allEvents];
        
        // Inicializar el calendario principal
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            try {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listMonth'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        list: 'Lista'
                    },
                    events: allEvents,
                    eventDisplay: 'block',
                    displayEventTime: false,
                    height: 'auto',
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    },
                    eventDidMount: function(info) {
                        // Añadir tooltips a los eventos
                        const title = info.event.title;
                        const status = info.event.extendedProps?.status || '';
                        const priority = info.event.extendedProps?.priority || '';
                        
                        // Configurar el tooltip con información adicional
                        info.el.title = `${title}\nEstado: ${status}\nPrioridad: ${priority}`;
                    },
                    eventClick: function(info) {
                        // Mostrar modal con detalles del evento
                        showEventModal(info.event);
                    },
                    dayMaxEvents: true,
                    dateClick: function(info) {
                        // Redirigir a la página de creación con la fecha seleccionada
                        window.location.href = "{{ route('activities.create') }}?date=" + info.dateStr;
                    }
                });
                
                calendar.render();
            } catch (error) {
                console.error('Error al inicializar el calendario:', error);
                calendarEl.innerHTML = `<div class="p-8 bg-danger-50 text-center rounded-lg">
                    <i class="bi bi-exclamation-circle text-4xl text-danger-500 mb-4 block"></i>
                    <h3 class="text-lg font-medium text-danger-800 mb-2">Error al cargar el calendario</h3>
                    <p class="text-danger-600">${error.message}</p>
                </div>`;
            }
        }
        
        // Cargar próximas actividades
        loadUpcomingEvents();
        
        // Cargar estadísticas
        loadStatistics();
        
        // Configurar filtros
        setupFilters();
        
        // Configurar modal
        setupModal();
        
        // Función para mostrar el modal con detalles del evento
        function showEventModal(event) {
            const modal = document.getElementById('event-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalDate = document.getElementById('modal-date');
            const modalStatus = document.getElementById('modal-status');
            const modalPriority = document.getElementById('modal-priority');
            const modalResponsible = document.getElementById('modal-responsible');
            const modalDescription = document.getElementById('modal-description');
            const modalObservations = document.getElementById('modal-observations');
            const modalEdit = document.getElementById('modal-edit');
            const modalView = document.getElementById('modal-view');
            
            // Obtener datos del evento
            const eventId = event.id;
            const eventTitle = event.title;
            const eventDate = event.start ? new Date(event.start).toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) : '-';
            const eventStatus = event.extendedProps?.status || 'No especificado';
            const eventPriority = event.extendedProps?.priority || 'No especificado';
            
            // Actualizar contenido del modal
            modalTitle.textContent = eventTitle;
            modalDate.textContent = eventDate;
            modalStatus.textContent = eventStatus.charAt(0).toUpperCase() + eventStatus.slice(1).replace('_', ' ');
            modalPriority.textContent = eventPriority.charAt(0).toUpperCase() + eventPriority.slice(1);
            
            // Obtener más detalles del evento mediante AJAX
            fetch(`/activities/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    modalResponsible.textContent = data.responsable ? data.responsable.name : 'No asignado';
                    modalDescription.textContent = data.descripcion || 'Sin descripción';
                    
                    // Combinar observaciones
                    let observations = [];
                    if (data.observacion_general) observations.push(data.observacion_general);
                    if (data.observacion_docente) observations.push(data.observacion_docente);
                    if (data.observacion_otros) observations.push(data.observacion_otros);
                    
                    modalObservations.textContent = observations.length > 0 ? observations.join('\n\n') : 'Sin observaciones';
                    
                    // Configurar botones
                    modalEdit.onclick = function() {
                        window.location.href = `/activities/${eventId}/edit`;
                    };
                    
                    modalView.onclick = function() {
                        window.location.href = `/activities/${eventId}`;
                    };
                })
                .catch(error => {
                    console.error('Error al obtener detalles del evento:', error);
                    modalDescription.textContent = 'Error al cargar los detalles';
                    modalObservations.textContent = 'Error al cargar las observaciones';
                });
            
            // Mostrar modal
            modal.style.display = 'block';
        }
        
        // Función para configurar el modal
        function setupModal() {
            const modal = document.getElementById('event-modal');
            const closeBtn = document.getElementById('modal-close');
            
            // Cerrar modal al hacer clic en el botón de cerrar
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            };
            
            // Cerrar modal al hacer clic fuera del contenido
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        }
        
        // Función para cargar próximas actividades
        function loadUpcomingEvents() {
            const upcomingEventsContainer = document.getElementById('upcoming-events');
            
            // Obtener la fecha actual
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            // Filtrar eventos futuros y ordenarlos por fecha
            const upcomingEvents = allEvents
                .filter(event => new Date(event.start) >= today)
                .sort((a, b) => new Date(a.start) - new Date(b.start))
                .slice(0, 5); // Limitar a 5 eventos
            
            if (upcomingEvents.length === 0) {
                upcomingEventsContainer.innerHTML = `
                    <div class="text-center text-gray-500 py-4">
                        <i class="bi bi-calendar-x text-2xl mb-2"></i>
                        <p>No hay actividades próximas</p>
                    </div>
                `;
                return;
            }
            
            // Generar HTML para los próximos eventos
            let html = '';
            upcomingEvents.forEach(event => {
                const eventDate = new Date(event.start);
                const formattedDate = eventDate.toLocaleDateString('es-ES', {
                    day: 'numeric',
                    month: 'short'
                });
                
                const statusClass = getStatusClass(event.extendedProps?.status);
                
                html += `
                    <div class="upcoming-event-item">
                        <div class="upcoming-event-date">${formattedDate}</div>
                        <div class="upcoming-event-title">${event.title}</div>
                        <div class="upcoming-event-status ${statusClass}">${formatStatus(event.extendedProps?.status)}</div>
                    </div>
                `;
            });
            
            upcomingEventsContainer.innerHTML = html;
        }
        
        // Función para cargar estadísticas
        function loadStatistics() {
            // Contar total de actividades
            document.getElementById('stat-total').textContent = allEvents.length;
            
            // Contar actividades por estado
            const completedCount = allEvents.filter(event => event.extendedProps?.status === 'realizada').length;
            const pendingCount = allEvents.filter(event => event.extendedProps?.status === 'pendiente').length;
            
            document.getElementById('stat-completed').textContent = completedCount;
            document.getElementById('stat-pending').textContent = pendingCount;
            
            // Contar actividades de alta prioridad
            const highPriorityCount = allEvents.filter(event => event.extendedProps?.priority === 'alta').length;
            document.getElementById('stat-high-priority').textContent = highPriorityCount;
        }
        
        // Función para configurar filtros
        function setupFilters() {
            const filterStatus = document.getElementById('filter-status');
            const filterPriority = document.getElementById('filter-priority');
            const filterDateRange = document.getElementById('filter-date-range');
            const applyFiltersBtn = document.getElementById('apply-filters');
            const resetFiltersBtn = document.getElementById('reset-filters');
            
            // Aplicar filtros
            applyFiltersBtn.onclick = function() {
                applyFilters();
            };
            
            // Restablecer filtros
            resetFiltersBtn.onclick = function() {
                filterStatus.value = '';
                filterPriority.value = '';
                filterDateRange.value = '';
                resetFilters();
            };
        }
        
        // Función para aplicar filtros
        function applyFilters() {
            const filterStatus = document.getElementById('filter-status').value;
            const filterPriority = document.getElementById('filter-priority').value;
            const filterDateRange = document.getElementById('filter-date-range').value;
            
            // Filtrar eventos
            filteredEvents = allEvents.filter(event => {
                // Filtrar por estado
                if (filterStatus && event.extendedProps?.status !== filterStatus.toLowerCase().replace(' ', '_')) {
                    return false;
                }
                
                // Filtrar por prioridad
                if (filterPriority && event.extendedProps?.priority !== filterPriority.toLowerCase()) {
                    return false;
                }
                
                // Filtrar por rango de fechas
                if (filterDateRange) {
                    const eventDate = new Date(event.start);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    switch (filterDateRange) {
                        case 'today':
                            return eventDate.toDateString() === today.toDateString();
                        case 'week':
                            const weekStart = new Date(today);
                            weekStart.setDate(today.getDate() - today.getDay());
                            const weekEnd = new Date(weekStart);
                            weekEnd.setDate(weekStart.getDate() + 6);
                            return eventDate >= weekStart && eventDate <= weekEnd;
                        case 'month':
                            return eventDate.getMonth() === today.getMonth() && 
                                   eventDate.getFullYear() === today.getFullYear();
                        case 'quarter':
                            const quarterStart = new Date(today.getFullYear(), Math.floor(today.getMonth() / 3) * 3, 1);
                            const quarterEnd = new Date(quarterStart.getFullYear(), quarterStart.getMonth() + 3, 0);
                            return eventDate >= quarterStart && eventDate <= quarterEnd;
                        case 'year':
                            return eventDate.getFullYear() === today.getFullYear();
                        default:
                            return true;
                    }
                }
                
                return true;
            });
            
            // Actualizar calendario
            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
            
            // Actualizar estadísticas
            loadStatistics();
            
            // Actualizar próximas actividades
            loadUpcomingEvents();
        }
        
        // Función para restablecer filtros
        function resetFilters() {
            filteredEvents = [...allEvents];
            
            // Actualizar calendario
            calendar.removeAllEvents();
            calendar.addEventSource(allEvents);
            
            // Actualizar estadísticas
            loadStatistics();
            
            // Actualizar próximas actividades
            loadUpcomingEvents();
        }
        
        // Función auxiliar para obtener la clase CSS del estado
        function getStatusClass(status) {
            switch (status) {
                case 'pendiente':
                    return 'status-pendiente';
                case 'en_seguimiento':
                    return 'status-en_seguimiento';
                case 'realizada':
                    return 'status-realizada';
                default:
                    return '';
            }
        }
        
        // Función auxiliar para formatear el estado
        function formatStatus(status) {
            if (!status) return 'No especificado';
            
            switch (status) {
                case 'pendiente':
                    return 'Pendiente';
                case 'en_seguimiento':
                    return 'En seguimiento';
                case 'realizada':
                    return 'Realizada';
                default:
                    return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
            }
        }
    });
</script>
@endsection