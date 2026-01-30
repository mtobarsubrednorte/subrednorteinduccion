@extends('layouts.module')

@section('title', 'Módulo 1: Introducción al bienestar')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/modulos.css') }}">
@endsection


@section('content')

<x-banner.banner />

<div class="breadcrumb">
    <a href="{{asset('pages/home')}}">Inicio</a>
    <span>/</span>
    <a href="#">Cursos</a>
    <span>/</span>
    <a href="#">Inducción Octubre 2025</a>
</div>

<div 
    class="contenido-modulo"
    x-data="{
        moduloSeleccionado: {{ $modulos->first()->id ?? 'null' }},
    }"
>

    <!-- Navegación izquierda -->
    <aside class="navegacion-modulos">
        <h3><i class="fas fa-list-ol"></i> Contenido del Curso</h3>

        @foreach($modulos as $index => $modulo)

            @php
                // Validar si el anterior está aprobado
                $aprobadoAnterior = true;

                if ($index > 0) {
                    $anterior = $modulos[$index - 1];
                    $aprobadoAnterior = DB::table('modulo_user')
                        ->where('user_id', auth()->id())
                        ->where('modulo_id', $anterior->id)
                        ->where('aprobado', true)
                        ->exists();
                }
            @endphp

            <div class="modulo-item {{ !$aprobadoAnterior ? 'disabled' : '' }}">
                <!-- Título del módulo -->
                <div 
                    class="modulo-titulo"
                    @if($aprobadoAnterior)
                        @click.stop="moduloSeleccionado = {{ $modulo->id }}"
                    @else 
                        style="opacity: 0.5; cursor: not-allowed;"
                    @endif
                >
                    <i class="fas fa-folder{{ $index == 0 ? '-open' : '' }}"></i>
                    Módulo {{ $index + 1 }}: {{ $modulo->title }}
                </div>

                <!-- Submódulos -->
                @if($aprobadoAnterior)
                    <ul class="clase-list">
                        @foreach($modulo->submodulos as $sub)
                            <li 
                                class="clase-item"
                                @click.stop="moduloSeleccionado = {{ $sub->id }}"
                            >
                                <i class="fas fa-play-circle"></i> 
                                {{ $sub->title }}
                            </li>
                        @endforeach

                        <!-- Examen -->
                        @if($modulo->preguntas->count() > 0)
                            <li 
                                class="clase-item"
                                @click.stop="moduloSeleccionado = 'examen-{{ $modulo->id }}'"
                            >
                                <i class="fas fa-clipboard-check"></i>
                                Realizar exámen
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        @endforeach


        @php
            $totalModulos = $modulos->count();
            $aprobados = DB::table('modulo_user')
                ->where('user_id', auth()->id())
                ->where('aprobado', true)
                ->count();

            $cursoAprobado = $totalModulos > 0 && $aprobados === $totalModulos;
        @endphp

        <!-- Certificado -->
        @if($cursoAprobado)
            <div class="modulo-item certificado">
                <div 
                    class="modulo-titulo text-success"
                    @click.stop="moduloSeleccionado = 'certificado'"
                >
                    <i class="fas fa-certificate"></i>
                    Descargar Certificado
                </div>
            </div>
        @endif

    </aside>

    <!-- Componente del módulo seleccionado -->
    <x-modulo 
        :modulos="$modulos" 
        :certificates="$certificates"
        :moduloSeleccionado="true"
    />

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const claseItems = document.querySelectorAll('.clase-item');

    claseItems.forEach(item => {
        item.addEventListener('click', () => {

            claseItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            console.log('Clase seleccionada:', item.textContent);
        });
    });
});
</script>

@endsection
