<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Actividades</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .header h1 {
            color: #4338ca;
            margin-bottom: 5px;
            font-size: 18pt;
        }
        .header p {
            color: #6c757d;
            margin-top: 0;
            font-size: 9pt;
        }
        .filters {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 9pt;
        }
        .filters strong {
            color: #4338ca;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px 6px;
            text-align: left;
        }
        th {
            background-color: #4338ca;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            font-size: 8pt;
            color: #6c757d;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
        }
        .estado-pendiente {
            color: #3b82f6;
            font-weight: bold;
        }
        .estado-realizada {
            color: #10b981;
            font-weight: bold;
        }
        .estado-seguimiento {
            color: #f59e0b;
            font-weight: bold;
        }
        .prioridad-alta {
            color: #ef4444;
            font-weight: bold;
        }
        .prioridad-media {
            color: #f59e0b;
            font-weight: bold;
        }
        .prioridad-baja {
            color: #10b981;
            font-weight: bold;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .page-number {
            text-align: right;
            font-size: 8pt;
            color: #6c757d;
        }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <!-- Simple text logo -->
            <h2 style="color: #4338ca; margin: 0;">CoordinaPro</h2>
            <small style="color: #6c757d;">Sistema de Gestión de Actividades</small>
        </div>
        <h1>Reporte de Actividades</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="filters">
        <strong>Filtros aplicados:</strong>
        @if(request('fecha_inicio'))
            Desde: {{ request('fecha_inicio') }}
        @endif
        @if(request('fecha_fin'))
            Hasta: {{ request('fecha_fin') }}
        @endif
        @if(request('estado'))
            Estado: {{ request('estado') }}
        @endif
        @if(request('prioridad'))
            Prioridad: {{ request('prioridad') }}
        @endif
        @if(!request('fecha_inicio') && !request('fecha_fin') && !request('estado') && !request('prioridad'))
            Ninguno (mostrando todas las actividades)
        @endif
    </div>

    @if($activities->isEmpty())
        <p style="text-align: center; padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 5px;">
            No hay actividades que coincidan con los criterios de búsqueda.
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 10%">Fecha</th>
                    <th style="width: 35%">Descripción</th>
                    <th style="width: 12%">Estado</th>
                    <th style="width: 12%">Prioridad</th>
                    <th style="width: 15%">Responsable</th>
                    <th style="width: 16%">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->fecha_actividad->format('d/m/Y') }}</td>
                        <td>{{ $activity->descripcion }}</td>
                        <td>
                            <span class="{{ $activity->estado === 'Pendiente' ? 'estado-pendiente' : 
                                    ($activity->estado === 'Realizada' ? 'estado-realizada' : 'estado-seguimiento') }}">
                                {{ $activity->estado }}
                            </span>
                        </td>
                        <td>
                            <span class="{{ $activity->prioridad === 'Alta' ? 'prioridad-alta' : 
                                    ($activity->prioridad === 'Media' ? 'prioridad-media' : 'prioridad-baja') }}">
                                {{ $activity->prioridad }}
                            </span>
                        </td>
                        <td>{{ $activity->responsable->name }}</td>
                        <td>{{ Str::limit($activity->observacion_general, 60) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <strong>Resumen:</strong><br>
            Total de actividades: {{ $activities->count() }}<br>
            
            @php
                $pendientes = $activities->where('estado', 'Pendiente')->count();
                $realizadas = $activities->where('estado', 'Realizada')->count();
                $enSeguimiento = $activities->where('estado', 'En seguimiento')->count();
                
                $alta = $activities->where('prioridad', 'Alta')->count();
                $media = $activities->where('prioridad', 'Media')->count();
                $baja = $activities->where('prioridad', 'Baja')->count();
            @endphp
            
            <strong>Por estado:</strong> 
            Pendientes: {{ $pendientes }}, 
            Realizadas: {{ $realizadas }}, 
            En seguimiento: {{ $enSeguimiento }}<br>
            
            <strong>Por prioridad:</strong>
            Alta: {{ $alta }}, 
            Media: {{ $media }}, 
            Baja: {{ $baja }}
        </div>
    @endif

    <div class="footer">
        <p>CoordinaPro - Sistema de Gestión de Actividades</p>
        <div class="page-number">Página 1</div>
    </div>
</body>
</html>