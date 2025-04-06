<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivitiesExport;

class ReportController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('reports.index', compact('users'));
    }

    public function getReportData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
            'responsible' => 'nullable|exists:users,id'
        ]);

        $query = Activity::query()
            ->whereBetween('fecha', [$request->start_date, $request->end_date])
            ->with('responsable');

        if ($request->status) {
            $query->where('estado', $request->status);
        }

        if ($request->priority) {
            $query->where('prioridad', $request->priority);
        }

        if ($request->responsible) {
            $query->where('responsable_id', $request->responsible);
        }

        $activities = $query->get();

        // Calcular estadísticas
        $stats = [
            'total' => $activities->count(),
            'completed' => $activities->where('estado', 'realizada')->count(),
            'pending' => $activities->where('estado', 'pendiente')->count(),
            'high_priority' => $activities->where('prioridad', 'alta')->count(),
            'by_status' => [
                'pendiente' => $activities->where('estado', 'pendiente')->count(),
                'en_seguimiento' => $activities->where('estado', 'en_seguimiento')->count(),
                'realizada' => $activities->where('estado', 'realizada')->count()
            ],
            'by_priority' => [
                'alta' => $activities->where('prioridad', 'alta')->count(),
                'media' => $activities->where('prioridad', 'media')->count(),
                'baja' => $activities->where('prioridad', 'baja')->count()
            ]
        ];

        return response()->json([
            'activities' => $activities,
            'stats' => $stats
        ]);
    }

    public function exportPdf(Request $request)
    {
        // TODO: Implementar exportación a PDF
        return response()->json(['message' => 'Funcionalidad en desarrollo']);
    }

    public function exportExcel(Request $request)
    {
        // TODO: Implementar exportación a Excel
        return response()->json(['message' => 'Funcionalidad en desarrollo']);
    }
} 