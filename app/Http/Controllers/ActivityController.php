<?php

namespace App\Http\Controllers;

use App\Exports\ActivitiesExport;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activity::query()->with('responsable');

        // Aplicar filtros si existen
        if ($request->filled('search')) {
            $query->where('descripcion', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_actividad', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_actividad', '<=', $request->fecha_fin);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        $activities = $query->orderBy('fecha_actividad', 'desc')->paginate(10);

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_actividad' => 'required|date',
            'descripcion' => 'required|string',
            'observacion_general' => 'nullable|string',
            'observacion_docente' => 'nullable|string',
            'observacion_otros' => 'nullable|string',
            'estado' => 'required|in:Pendiente,Realizada,En seguimiento',
            'prioridad' => 'required|in:Alta,Media,Baja',
        ]);

        $validated['fecha_actual'] = now();
        $validated['responsable_id'] = auth()->id();

        Activity::create($validated);

        return redirect()->route('activities.index')
            ->with('success', 'Actividad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return response()->json($activity->load('responsable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'fecha_actividad' => 'required|date',
            'descripcion' => 'required|string',
            'observacion_general' => 'nullable|string',
            'observacion_docente' => 'nullable|string',
            'observacion_otros' => 'nullable|string',
            'estado' => 'required|in:Pendiente,Realizada,En seguimiento',
            'prioridad' => 'required|in:Alta,Media,Baja',
        ]);

        $activity->update($validated);

        return redirect()->route('activities.index')
            ->with('success', 'Actividad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Actividad eliminada exitosamente.');
    }

    public function calendar()
    {
        // Obtener todas las actividades
        $activitiesQuery = Activity::all();
        
        // Convertir a formato de eventos para el calendario
        $events = [];
        foreach ($activitiesQuery as $activity) {
            $events[] = [
                'id' => $activity->id,
                'title' => $activity->descripcion,
                'start' => $activity->fecha_actividad->format('Y-m-d'), // Solo fecha sin hora
                'allDay' => true,
                'backgroundColor' => $this->getStatusColor($activity->estado),
                'borderColor' => $this->getStatusColor($activity->estado),
                'textColor' => '#ffffff',
            ];
        }
        
        // Verificar si hay datos
        $debugInfo = [
            'totalActivities' => $activitiesQuery->count(),
            'sampleActivity' => $activitiesQuery->first(),
            'totalEvents' => count($events),
            'sampleEvent' => !empty($events) ? $events[0] : null
        ];
        
        return view('activities.calendar', compact('events', 'debugInfo'));
    }
    
    public function calendarData()
    {
        $activities = Activity::all();
        
        return response()->json($activities->map(function ($activity) {
            return [
                'id' => $activity->id,
                'title' => $activity->descripcion,
                'start' => $activity->fecha_actividad->format('Y-m-d'),
                'url' => route('activities.show', $activity->id),
                'backgroundColor' => $this->getStatusColor($activity->estado),
                'borderColor' => $this->getPriorityColor($activity->prioridad),
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'status' => strtolower(str_replace(' ', '_', $activity->estado)),
                    'priority' => strtolower($activity->prioridad)
                ]
            ];
        }));
    }
    
    private function getStatusColor($estado)
    {
        switch ($estado) {
            case 'Realizada':
                return '#10b981'; // verde
            case 'En seguimiento':
                return '#f59e0b'; // amarillo
            default:
                return '#3b82f6'; // azul (pendiente)
        }
    }
    
    private function getPriorityColor($prioridad)
    {
        switch ($prioridad) {
            case 'Alta':
                return '#ef4444'; // rojo
            case 'Media':
                return '#f59e0b'; // amarillo
            default:
                return '#10b981'; // verde (baja)
        }
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ActivitiesExport($request), 'actividades.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Activity::query()->with('responsable');

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_actividad', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_actividad', '<=', $request->fecha_fin);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('responsable_id')) {
            $query->where('responsable_id', $request->responsable_id);
        }

        $activities = $query->orderBy('fecha_actividad', 'desc')->get();
        
        $pdf = PDF::loadView('reports.pdf', compact('activities'));
        
        return $pdf->download('actividades.pdf');
    }

    public function dashboard()
    {
        // Actividades pendientes
        $pendientes = Activity::where('estado', 'Pendiente')->count();
        
        // Actividades en seguimiento
        $enSeguimiento = Activity::where('estado', 'En seguimiento')->count();
        
        // Actividades realizadas
        $realizadas = Activity::where('estado', 'Realizada')->count();
        
        // Próximas actividades (7 días)
        $proximas = Activity::where('fecha_actividad', '>=', now())
                            ->where('fecha_actividad', '<=', now()->addDays(7))
                            ->orderBy('fecha_actividad')
                            ->limit(5)
                            ->get();
        
        // Actividades por mes (último año)
        $actividadesPorMes = DB::table('activities')
            ->select(DB::raw('MONTH(fecha_actividad) as mes, YEAR(fecha_actividad) as anio, count(*) as total'))
            ->whereRaw('fecha_actividad >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)')
            ->groupBy('mes', 'anio')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();
        
        // Formatear datos para el gráfico
        $meses = [];
        $totales = [];
        
        foreach ($actividadesPorMes as $registro) {
            $nombreMes = date('M', mktime(0, 0, 0, $registro->mes, 1));
            $meses[] = $nombreMes . ' ' . $registro->anio;
            $totales[] = $registro->total;
        }
        
        return view('dashboard', compact('pendientes', 'enSeguimiento', 'realizadas', 'proximas', 'meses', 'totales'));
    }
}
