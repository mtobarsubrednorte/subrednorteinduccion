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
    >
  </div>

  <div class="contenido-modulo" x-data="{ moduloSeleccionado: {{ $modulos->first()->id ?? 'null' }} }">
    <!-- Navegación de módulos -->
    <aside class="navegacion-modulos">
      <h3><i class="fas fa-list-ol"></i> Contenido del Curso</h3>

      @foreach($modulos as $index => $modulo)
        @php
          $aprobadoAnterior = true;

          if ($index > 0) {
            $anterior = $modulos[$index - 1];
            $aprobadoAnterior = \DB::table('modulo_user')
              ->where('user_id', auth()->id())
              ->where('modulo_id', $anterior->id)
              ->where('aprobado', true)
              ->exists();
          }
        @endphp

        <div class="modulo-item {{ !$aprobadoAnterior ? 'disabled' : '' }}">
          <div class="modulo-titulo" @if($aprobadoAnterior) @click.stop="moduloSeleccionado = {{ $modulo->id }}" @else
          style="opacity: 0.5; cursor: not-allowed;" @endif>
            <i class="fas fa-folder{{ $index == 0 ? '-open' : '' }}"></i>
            Módulo {{ $index + 1 }}: {{ $modulo->title }}
          </div>

          @if($aprobadoAnterior)
            <ul class="clase-list">
              @foreach($modulo->submodulos as $sub)
                <li class="clase-item" @click.stop="moduloSeleccionado = {{ $sub->id }}">
                  <i class="fas fa-play-circle"></i> {{ $sub->title }}
                </li>
              @endforeach

              @if($modulo->preguntas->count() > 0)
                <li class="clase-item" @click.stop="moduloSeleccionado = 'examen-{{ $modulo->id }}'">
                  <i class="fas fa-play-circle"></i> Realizar Examen
                </li>
              @endif
            </ul>
          @endif
        </div>
      @endforeach

      @php
        $totalModulos = $modulos->count();
        $aprobados = \DB::table('modulo_user')
          ->where('user_id', auth()->id())
          ->where('aprobado', true)
          ->count();

        $cursoAprobado = $totalModulos > 0 && $aprobados === $totalModulos;
      @endphp

      @if($cursoAprobado)
        <div class="modulo-item certificado">
          <div class="modulo-titulo text-success" @click.stop="moduloSeleccionado = 'certificado'">
            <i class="fas fa-certificate"></i>
            Descargar Certificado
          </div>
        </div>
      @endif

    </aside>

    <!-- componente: le pasamos los módulos (no hace falta pasar moduloId) -->
    <x-modulo :modulos="$modulos" :link1="$modulo->genilay_recursos_link1" :link2="$modulo->genilay_recursos_link2" />
  </div>

  <script>
    // Funcionalidad para la navegación de clases
    document.addEventListener('DOMContentLoaded', function () {
      const claseItems = document.querySelectorAll('.clase-item');

      claseItems.forEach(item => {
        item.addEventListener('click', () => {
          // Remover clase active de todos los items
          claseItems.forEach(i => i.classList.remove('active'));

          // Agregar clase active al item seleccionado
          item.classList.add('active');

          // Aquí iría la lógica para cargar el contenido de la clase seleccionada
          console.log('Clase seleccionada:', item.textContent);
        });
      });

      // Simular marcado de clase como completada
      const completeBtn = document.querySelector('.nav-btn:not(.outline)');
      completeBtn.addEventListener('click', function () {
        const currentItem = document.querySelector('.clase-item.active');
        if (currentItem && !currentItem.querySelector('.fa-circle-check')) {
          const checkIcon = document.createElement('i');
          checkIcon.className = 'fas fa-circle-check';
          currentItem.appendChild(checkIcon);

          // Cambiar texto del botón
          completeBtn.innerHTML = 'Completado <i class="fas fa-check-double"></i>';
          completeBtn.style.background = 'var(--secondary)';
        }
      });
    });

  </script>


@endsection