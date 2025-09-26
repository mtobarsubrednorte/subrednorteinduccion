@extends('layouts.app')

@section('content')
    <x-header />
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-tachometer-alt"></i> Panel de Administración
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Usuarios</h5>
                                        <p class="card-text">Gestionar usuarios del sistema</p>
                                        <a href="{{ route('admin.usuarios') }}" class="btn btn-light">Ir a Usuarios</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-info mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Reportes</h5>
                                        <p class="card-text">Ver reportes y estadísticas</p>
                                        <a href="{{ route('admin.reportes') }}" class="btn btn-light">Ir a Reportes</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-warning mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Estadísticas</h5>
                                        <p class="card-text">Ver métricas del sistema</p>
                                        <a href="{{ route('admin.estadisticas') }}" class="btn btn-light">Ir a
                                            Estadísticas</a>
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