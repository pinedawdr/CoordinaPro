<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivitiesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Activity::query()
            ->with('responsable')
            ->when($this->request->fecha_inicio, function ($query) {
                return $query->whereDate('fecha_actividad', '>=', $this->request->fecha_inicio);
            })
            ->when($this->request->fecha_fin, function ($query) {
                return $query->whereDate('fecha_actividad', '<=', $this->request->fecha_fin);
            })
            ->when($this->request->estado, function ($query) {
                return $query->where('estado', $this->request->estado);
            })
            ->when($this->request->prioridad, function ($query) {
                return $query->where('prioridad', $this->request->prioridad);
            })
            ->when($this->request->search, function ($query) {
                return $query->where('descripcion', 'like', '%' . $this->request->search . '%');
            })
            ->orderBy('fecha_actividad', 'desc')
            ->get();
    }

    public function map($activity): array
    {
        return [
            $activity->id,
            $activity->fecha_actual->format('d/m/Y H:i'),
            $activity->fecha_actividad->format('d/m/Y'),
            $activity->descripcion,
            $activity->observacion_general,
            $activity->observacion_docente,
            $activity->observacion_otros,
            $activity->estado,
            $activity->prioridad,
            $activity->responsable ? $activity->responsable->name : 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha de Registro',
            'Fecha de Actividad',
            'Descripción',
            'Observación General',
            'Observación para Docente',
            'Observación para Otros',
            'Estado',
            'Prioridad',
            'Responsable',
        ];
    }
}