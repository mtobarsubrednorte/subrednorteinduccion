@extends('layouts.app')

@section('content')
<div class="container py-4 bienvenida-bg"
     style="background-image: url('{{ asset('images/imagen_entorno.jpg') }}');
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            padding: 30px;">

    <!-- Botones de navegación -->
    <div class="mb-4 d-flex justify-content-end gap-2">
        <a href="{{ route('modules.bienvenida') }}" class="btn btn-primary">Bienvenida</a>
        <a href="{{ route('modules.gestion_territorial') }}" class="btn btn-primary">Gestión Territorial</a>
        <a href="{{ route('modules.final') }}" class="btn btn-primary">Módulo Final</a>
    </div>

    <h1 class="mb-4 text-center text-white">{{ $module->title }}</h1>

    <!-- Barra de progreso -->
    <div class="progress mb-4" style="height: 30px;">
        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
             role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            0%
        </div>
    </div>

    <!-- Contenido dinámico (video, genially, etc.) -->
    @yield('module-content')

    <!-- Mensaje de completado -->
    <div id="completadoMessage" class="alert alert-success mt-4 text-center" style="display:none;">
        🎉 ¡Has completado el módulo!
    </div>

    <!-- Botón Siguiente (cambia dinámicamente según módulo) -->
    <div class="mt-4 text-center">
        @if($module->id === 1)
            <a href="{{ route('modules.gestion_territorial') }}" class="btn btn-success btn-lg">Siguiente</a>
        @elseif($module->id === 2)
            <a href="{{ route('modules.final') }}" class="btn btn-success btn-lg">Siguiente</a>
        @elseif($module->id === 3)
            <a href="{{ route('certificate.generate') }}" class="btn btn-warning btn-lg">🎓 Descargar Certificado</a>
        @endif
    </div>
</div>

@include('modules.scripts')
@endsection