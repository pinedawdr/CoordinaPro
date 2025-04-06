@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .report-filters {
        background-color: #f9fafb;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-group {
        margin-bottom: 1rem;
    }
    
    .filter-group:last-child {
        margin-bottom: 0;
    }
    
    .filter-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #4b5563;
    }
    
    .date-range-container {
        display: flex;
        gap: 1rem;
    }
    
    .date-input {
        flex: 1;
    }
    
    .report-card {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .report-card-header {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }
    
    .report-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .report-card-body {
        padding: 1rem;
    }
    
    .report-card-footer {
        padding: 1rem;
        border-top: 1px solid #e5e7eb;
        background-color: #f9fafb;
        display: flex;
        justify-content: flex-end;
    }
    
    .report-summary {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .summary-card {
        background-color: #fff;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }
    
    .summary-title {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }
    
    .summary-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
    }
    
    .summary-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .summary-primary {
        color: #4f46e5;
    }
    
    .summary-success {
        color: #10b981;
    }
    
    .summary-warning {
        color: #f59e0b;
    }
    
    .summary-danger {
        color: #ef4444;
    }
    
    .report-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .report-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .report-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .report-table tr:last-child td {
        border-bottom: none;
    }
    
    .report-table tr:hover td {
        background-color: #f9fafb;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
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
    
    .priority-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .priority-alta {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .priority-media {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .priority-baja {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 1.5rem;
    }
    
    .report-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .report-actions button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .report-actions .btn-primary {
        background-color: #4f46e5;
        color: white;
        border: none;
    }
    
    .report-actions .btn-outline {
        background-color: transparent;
        color: #4b5563;
        border: 1px solid #d1d5db;
    }
    
    .report-actions .btn-success {
        background-color: #10b981;
        color: white;
        border: none;
    }
    
    .report-actions .btn-danger {
        background-color: #ef4444;
        color: white;
        border: none;
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="bi bi-file-earmark-bar-graph mr-2 text-primary-600"></i>
            Reportes
        </h1>
        <div class="flex space-x-3">
            <button id="export-pdf" class="btn-outline">
                <i class="bi bi-file-pdf mr-2"></i>
                Exportar PDF
            </button>
            <button id="export-excel" class="btn-outline">
                <i class="bi bi-file-excel mr-2"></i>
                Exportar Excel
            </button>
        </div>
    </div>

    <!-- Filtros de reporte -->
    <div class="report-filters">
        <form id="report-form">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="filter-group">
                    <label for="date-range" class="filter-label">Rango de Fechas</label>
                    <div class="date-range-container">
                        <div class="date-input">
                            <input type="text" id="start-date" class="form-input w-full" placeholder="Fecha inicial">
                        </div>
                        <div class="date-input">
                            <input type="text" id="end-date" class="form-input w-full" placeholder="Fecha final">
                        </div>
                    </div>
                </div>
                
                <div class="filter-group">
                    <label for="filter-status" class="filter-label">Estado</label>
                    <select id="filter-status" class="form-select w-full">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="en_seguimiento">En seguimiento</option>
                        <option value="realizada">Realizada</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="filter-priority" class="filter-label">Prioridad</label>
                    <select id="filter-priority" class="form-select w-full">
                        <option value="">Todas</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="filter-responsible" class="filter-label">Responsable</label>
                    <select id="filter-responsible" class="form-select w-full">
                        <option value="">Todos</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <button type="button" id="reset-filters" class="btn-outline mr-2">
                    <i class="bi bi-x-circle mr-1"></i> Restablecer
                </button>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-search mr-1"></i> Generar Reporte
                </button>
            </div>
        </form>
    </div>

    <!-- Resumen de reporte -->
    <div class="report-summary">
        <div class="summary-card">
            <div class="summary-icon summary-primary">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="summary-title">Total Actividades</div>
            <div class="summary-value" id="total-activities">0</div>
        </div>
        
        <div class="summary-card">
            <div class="summary-icon summary-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="summary-title">Actividades Completadas</div>
            <div class="summary-value" id="completed-activities">0</div>
        </div>
        
        <div class="summary-card">
            <div class="summary-icon summary-warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="summary-title">Actividades Pendientes</div>
            <div class="summary-value" id="pending-activities">0</div>
        </div>
        
        <div class="summary-card">
            <div class="summary-icon summary-danger">
                <i class="bi bi-exclamation-circle"></i>
            </div>
            <div class="summary-title">Actividades de Alta Prioridad</div>
            <div class="summary-value" id="high-priority-activities">0</div>
        </div>
    </div>

    <!-- Gráficos de reporte -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="report-card">
            <div class="report-card-header">
                <h3 class="report-card-title">Actividades por Estado</h3>
            </div>
            <div class="report-card-body">
                <div class="chart-container">
                    <canvas id="status-chart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="report-card">
            <div class="report-card-header">
                <h3 class="report-card-title">Actividades por Prioridad</h3>
            </div>
            <div class="report-card-body">
                <div class="chart-container">
                    <canvas id="priority-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de reporte -->
    <div class="report-card">
        <div class="report-card-header">
            <h3 class="report-card-title">Detalle de Actividades</h3>
        </div>
        <div class="report-card-body">
            <div class="overflow-x-auto">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Responsable</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="activities-table-body">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                Seleccione un rango de fechas y haga clic en "Generar Reporte"
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="report-card-footer">
            <div class="report-actions">
                <button id="view-details" class="btn-primary" disabled>
                    <i class="bi bi-eye mr-1"></i> Ver Detalles
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar selectores de fecha
        flatpickr("#start-date", {
            locale: "es",
            dateFormat: "d/m/Y",
            maxDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                // Actualizar la fecha mínima del selector de fecha final
                endDatePicker.set("minDate", dateStr);
            }
        });
        
        const endDatePicker = flatpickr("#end-date", {
            locale: "es",
            dateFormat: "d/m/Y",
            maxDate: "today"
        });
        
        // Variables para los gráficos
        let statusChart = null;
        let priorityChart = null;
        
        // Manejar el envío del formulario
        document.getElementById('report-form').addEventListener('submit', function(e) {
            e.preventDefault();
            generateReport();
        });
        
        // Manejar el restablecimiento de filtros
        document.getElementById('reset-filters').addEventListener('click', function() {
            document.getElementById('start-date').value = '';
            document.getElementById('end-date').value = '';
            document.getElementById('filter-status').value = '';
            document.getElementById('filter-priority').value = '';
            document.getElementById('filter-responsible').value = '';
            
            // Restablecer gráficos
            resetCharts();
            
            // Restablecer tabla
            document.getElementById('activities-table-body').innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Seleccione un rango de fechas y haga clic en "Generar Reporte"
                    </td>
                </tr>
            `;
            
            // Deshabilitar botón de ver detalles
            document.getElementById('view-details').disabled = true;
            
            // Restablecer resumen
            document.getElementById('total-activities').textContent = '0';
            document.getElementById('completed-activities').textContent = '0';
            document.getElementById('pending-activities').textContent = '0';
            document.getElementById('high-priority-activities').textContent = '0';
        });
        
        // Función para generar el reporte
        function generateReport() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const status = document.getElementById('filter-status').value;
            const priority = document.getElementById('filter-priority').value;
            const responsible = document.getElementById('filter-responsible').value;
            
            // Validar fechas
            if (!startDate || !endDate) {
                alert('Por favor, seleccione un rango de fechas');
                return;
            }
            
            // Mostrar indicador de carga
            document.getElementById('activities-table-body').innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="flex justify-center items-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
                            <span class="ml-2">Cargando datos...</span>
                        </div>
                    </td>
                </tr>
            `;
            
            // Construir URL con parámetros
            const params = new URLSearchParams({
                start_date: startDate,
                end_date: endDate
            });
            
            if (status) params.append('status', status);
            if (priority) params.append('priority', priority);
            if (responsible) params.append('responsible', responsible);
            
            // Realizar petición al backend
            fetch(`/reports/data?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    // Actualizar resumen
                    document.getElementById('total-activities').textContent = data.stats.total;
                    document.getElementById('completed-activities').textContent = data.stats.completed;
                    document.getElementById('pending-activities').textContent = data.stats.pending;
                    document.getElementById('high-priority-activities').textContent = data.stats.high_priority;
                    
                    // Actualizar gráficos
                    updateCharts(data.activities);
                    
                    // Actualizar tabla
                    updateTable(data.activities);
                    
                    // Habilitar botón de ver detalles
                    document.getElementById('view-details').disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('activities-table-body').innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center py-4 text-red-500">
                                Error al cargar los datos. Por favor, intente nuevamente.
                            </td>
                        </tr>
                    `;
                });
        }
        
        // Función para actualizar los gráficos
        function updateCharts(activities) {
            // Datos para el gráfico de estado
            const statusData = {
                pendiente: activities.filter(a => a.estado === 'pendiente').length,
                en_seguimiento: activities.filter(a => a.estado === 'en_seguimiento').length,
                realizada: activities.filter(a => a.estado === 'realizada').length
            };
            
            // Datos para el gráfico de prioridad
            const priorityData = {
                alta: activities.filter(a => a.prioridad === 'alta').length,
                media: activities.filter(a => a.prioridad === 'media').length,
                baja: activities.filter(a => a.prioridad === 'baja').length
            };
            
            // Destruir gráficos existentes
            if (statusChart) {
                statusChart.destroy();
            }
            
            if (priorityChart) {
                priorityChart.destroy();
            }
            
            // Crear gráfico de estado
            const statusCtx = document.getElementById('status-chart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: ['Pendiente', 'En seguimiento', 'Realizada'],
                    datasets: [{
                        data: [statusData.pendiente, statusData.en_seguimiento, statusData.realizada],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(16, 185, 129, 0.7)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(16, 185, 129, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            
            // Crear gráfico de prioridad
            const priorityCtx = document.getElementById('priority-chart').getContext('2d');
            priorityChart = new Chart(priorityCtx, {
                type: 'bar',
                data: {
                    labels: ['Alta', 'Media', 'Baja'],
                    datasets: [{
                        label: 'Cantidad de actividades',
                        data: [priorityData.alta, priorityData.media, priorityData.baja],
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(16, 185, 129, 0.7)'
                        ],
                        borderColor: [
                            'rgba(239, 68, 68, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(16, 185, 129, 1)'
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
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
        
        // Función para restablecer los gráficos
        function resetCharts() {
            if (statusChart) {
                statusChart.destroy();
                statusChart = null;
            }
            
            if (priorityChart) {
                priorityChart.destroy();
                priorityChart = null;
            }
            
            // Limpiar canvas
            const statusCtx = document.getElementById('status-chart').getContext('2d');
            statusCtx.clearRect(0, 0, statusCtx.canvas.width, statusCtx.canvas.height);
            
            const priorityCtx = document.getElementById('priority-chart').getContext('2d');
            priorityCtx.clearRect(0, 0, priorityCtx.canvas.width, priorityCtx.canvas.height);
        }
        
        // Función para actualizar la tabla
        function updateTable(activities) {
            const tableBody = document.getElementById('activities-table-body');
            
            if (activities.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            No se encontraron actividades para el rango de fechas seleccionado
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            
            activities.forEach(activity => {
                const statusClass = getStatusClass(activity.estado);
                const priorityClass = getPriorityClass(activity.prioridad);
                
                // Verificar si responsable existe y tiene la propiedad name
                const responsableName = activity.responsable && activity.responsable.name 
                    ? activity.responsable.name 
                    : 'No asignado';
                
                html += `
                    <tr data-id="${activity.id}">
                        <td>${activity.fecha}</td>
                        <td>${activity.titulo}</td>
                        <td><span class="status-badge ${statusClass}">${formatStatus(activity.estado)}</span></td>
                        <td><span class="priority-badge ${priorityClass}">${formatPriority(activity.prioridad)}</span></td>
                        <td>${responsableName}</td>
                        <td>
                            <button class="btn-outline btn-sm view-activity" data-id="${activity.id}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            tableBody.innerHTML = html;
            
            // Agregar eventos a los botones de ver actividad
            document.querySelectorAll('.view-activity').forEach(button => {
                button.addEventListener('click', function() {
                    const activityId = this.getAttribute('data-id');
                    window.location.href = `/activities/${activityId}`;
                });
            });
            
            // Agregar eventos a las filas de la tabla
            document.querySelectorAll('#activities-table-body tr').forEach(row => {
                row.addEventListener('click', function(e) {
                    // No hacer nada si se hizo clic en un botón
                    if (e.target.closest('button')) {
                        return;
                    }
                    
                    // Seleccionar la fila
                    document.querySelectorAll('#activities-table-body tr').forEach(r => {
                        r.classList.remove('bg-primary-50');
                    });
                    
                    this.classList.add('bg-primary-50');
                    
                    // Habilitar el botón de ver detalles
                    document.getElementById('view-details').disabled = false;
                });
            });
        }
        
        // Función para obtener la clase CSS del estado
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
        
        // Función para obtener la clase CSS de la prioridad
        function getPriorityClass(priority) {
            switch (priority) {
                case 'alta':
                    return 'priority-alta';
                case 'media':
                    return 'priority-media';
                case 'baja':
                    return 'priority-baja';
                default:
                    return '';
            }
        }
        
        // Función para formatear el estado
        function formatStatus(status) {
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
        
        // Función para formatear la prioridad
        function formatPriority(priority) {
            switch (priority) {
                case 'alta':
                    return 'Alta';
                case 'media':
                    return 'Media';
                case 'baja':
                    return 'Baja';
                default:
                    return priority.charAt(0).toUpperCase() + priority.slice(1);
            }
        }
        
        // Manejar exportación a PDF
        document.getElementById('export-pdf').addEventListener('click', function() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const status = document.getElementById('filter-status').value;
            const priority = document.getElementById('filter-priority').value;
            const responsible = document.getElementById('filter-responsible').value;
            
            if (!startDate || !endDate) {
                alert('Por favor, seleccione un rango de fechas');
                return;
            }
            
            // Construir URL con parámetros
            const params = new URLSearchParams({
                start_date: startDate,
                end_date: endDate
            });
            
            if (status) params.append('status', status);
            if (priority) params.append('priority', priority);
            if (responsible) params.append('responsible', responsible);
            
            // Redirigir a la ruta de exportación PDF
            window.location.href = `/reports/export-pdf?${params.toString()}`;
        });
        
        // Manejar exportación a Excel
        document.getElementById('export-excel').addEventListener('click', function() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const status = document.getElementById('filter-status').value;
            const priority = document.getElementById('filter-priority').value;
            const responsible = document.getElementById('filter-responsible').value;
            
            if (!startDate || !endDate) {
                alert('Por favor, seleccione un rango de fechas');
                return;
            }
            
            // Construir URL con parámetros
            const params = new URLSearchParams({
                start_date: startDate,
                end_date: endDate
            });
            
            if (status) params.append('status', status);
            if (priority) params.append('priority', priority);
            if (responsible) params.append('responsible', responsible);
            
            // Redirigir a la ruta de exportación Excel
            window.location.href = `/reports/export-excel?${params.toString()}`;
        });
        
        // Manejar ver detalles
        document.getElementById('view-details').addEventListener('click', function() {
            const selectedRow = document.querySelector('#activities-table-body tr.bg-primary-50');
            
            if (selectedRow) {
                const activityId = selectedRow.getAttribute('data-id');
                window.location.href = `/activities/${activityId}`;
            }
        });
    });
</script>
@endsection 