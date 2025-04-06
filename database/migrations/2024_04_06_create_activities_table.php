<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_actual');
            $table->date('fecha_actividad');
            $table->text('descripcion');
            $table->text('observacion_general')->nullable();
            $table->text('observacion_docente')->nullable();
            $table->text('observacion_otros')->nullable();
            $table->enum('estado', ['Pendiente', 'Realizada', 'En seguimiento']);
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->foreignId('responsable_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
};