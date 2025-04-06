@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/simple-calendar-js@1.4.4/dist/simple-calendar.min.css" rel="stylesheet">
<style>
    #calendar {
        max-width: 1200px;
        margin: 0 auto;
    }
    .calendar-event {
        cursor: pointer;
        padding: 5px;
        margin-bottom: 3px;
        border-radius: 3px;
        color: white;
        font-size: 12px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .priority-alta { border-left: 3px solid #dc2626; }
    .priority-media { border-left: 3px solid #f59e0b; }
    .priority-baja { border-left: 3px solid #10b981; }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Calendario de Actividades</h1>
        <div>
            <a href="{{ route('activities.create') }}" class="btn-primary">Nueva Actividad</a>
            <a href="{{ route('activities.index') }}" class="btn-outline ml-2">Volver a la lista</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/simple-calendar-js@1.4.4/dist/simple-calendar.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const rawEvents = @json($activities);
        
        // Formatear eventos para Simple Calendar
        const events = rawEvents.map(event => {
            const eventDate = new Date(event.start);
            return {
                startDate: eventDate,
                endDate: eventDate,
                name: event.title,
                color: event.backgroundColor,
                url: event.url,
                priority: event.extendedProps?.priority || 'media'
            };
        });
        
        if (!calendarEl) return;
        
        try {
            const calendar = new SimpleCalendar({
                container: calendarEl,
                eventsData: events,
                mode: 'month',
                processEventsData: false,
                customEventRenderer: function(event, element) {
                    const div = document.createElement('div');
                    div.className = `calendar-event priority-${event.priority}`;
                    div.style.backgroundColor = event.color;
                    div.textContent = event.name;
                    div.addEventListener('click', function() {
                        window.location.href = event.url;
                    });
                    element.append(div);
                }
            });
        } catch (error) {
            console.error('Error al inicializar el calendario:', error);
            calendarEl.innerHTML = `<div class="p-4 bg-red-50 text-red-800 rounded">
                Error al cargar el calendario: ${error.message}
            </div>`;
        }
    });
</script>
@endsection
