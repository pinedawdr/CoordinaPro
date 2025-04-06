@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Calendario de Actividades</h2>
                </div>

                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'interaction'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            events: '/activities/calendar-data',
            eventClick: function(info) {
                // Aquí puedes agregar la lógica para mostrar detalles de la actividad
                alert('Actividad: ' + info.event.title);
            }
        });
        calendar.render();
    });
</script>
@endpush
@endsection
