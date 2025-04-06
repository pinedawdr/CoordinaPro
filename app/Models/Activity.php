<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_actual',
        'fecha_actividad',
        'descripcion',
        'observacion_general',
        'observacion_docente',
        'observacion_otros',
        'estado',
        'prioridad',
        'responsable_id',
    ];

    protected $casts = [
        'fecha_actual' => 'datetime',
        'fecha_actividad' => 'date',
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
