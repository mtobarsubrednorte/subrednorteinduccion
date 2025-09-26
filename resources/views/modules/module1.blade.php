@extends('layouts.module')

@section('title', 'Módulo 1: Introducción al bienestar')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/modulos.css') }}">

@endsection


@section('content')

  <div class="breadcrumb">
    <a href="{{asset('pages/home')}}">Inicio</a>
    <span>/</span>
    <a href="#">Cursos</a>
    <span>/</span>
    <a href="#">Inducción Septiembre 2025</a>
    <span>/</span>
    <a href="#">Módulo 1: Introducción al bienestar</a>
  </div>

  <div class="contenido-modulo">
    <!-- Navegación de módulos -->
    <aside class="navegacion-modulos">
      <h3><i class="fas fa-list-ol"></i> Contenido del Curso</h3>

      <div class="modulo-item">
        <div class="modulo-titulo">
          <i class="fas fa-folder-open"></i>
          Módulo 1: Introducción al bienestar
        </div>
        <ul class="clase-list">
          <li class="clase-item active">
            <i class="fas fa-play-circle"></i> Bienvenida al curso
            <i class="fas fa-circle-check"></i>
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Realizar Examen
          </li>

        </ul>
      </div>

      <div class="modulo-item">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 2: Salud física
        </div>
        <ul class="clase-list">
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Introducción
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Nutrición consciente
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Actividad física
          </li>
        </ul>
      </div>
    </aside>
    {{-- modulo dinamico para seleccionar las clases --}}
    {{-- <x-modulo :cursos="$module" /> --}}
    <x-modulo />

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

    document.addEventListener("DOMContentLoaded", function () {
      // Cargar Genially script
      (function (d) {
        var js, id = "genially-embed-js", ref = d.getElementsByTagName("script")[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement("script");
        js.id = id;
        js.async = true;
        js.src = "https://view.genially.com/static/embed/embed.js";
        ref.parentNode.insertBefore(js, ref);
      }(document));
    });

  </script>


@endsection