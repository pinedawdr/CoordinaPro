@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Bienvenido a CoordinaPro</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                                    <h3>Actividades</h3>
                                    <p>Gestiona todas las actividades de coordinación del instituto.</p>
                                    <a href="{{ route('activities.index') }}" class="btn btn-primary">
                                        Ver Actividades
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar fa-3x text-success mb-3"></i>
                                    <h3>Calendario</h3>
                                    <p>Visualiza las actividades en un calendario interactivo.</p>
                                    <a href="{{ route('activities.calendar') }}" class="btn btn-success">
                                        Ver Calendario
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                                    <h3>Reportes</h3>
                                    <p>Genera reportes detallados de las actividades.</p>
                                    <a href="{{ route('reports.index') }}" class="btn btn-info">
                                        Ver Reportes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 