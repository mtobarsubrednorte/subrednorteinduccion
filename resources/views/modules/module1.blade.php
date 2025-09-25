<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Módulos de Clases - MAS Bienestar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/modulos.css') }}">
</head>
<body>

  <header>
    <div class="logo-container">
      <img src="{{ asset('images/logos/Logo_entorno.jpg') }}" alt="Logo MAS Bienestar">
      <h1>MAS Bienestar en tu hogar</h1>
    </div>
    <div class="usuario">
      <i class="fas fa-user-circle"></i>
      <span>María Rodríguez</span>
    </div>
  </header>

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
      
      <div class="modulo-item" data-modulo="1">
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
      
      <div class="modulo-item" data-modulo="2">
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

      <div class="modulo-item" data-modulo="4">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 4: Aplicativo GitApps
        </div>
        <ul class="clase-list">
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Escalera de pasos
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Acciones colectivas e individuales
          </li>
        </ul>
      </div>
    </aside>

    {{-- Contenido dinámico --}}
    <x-modulo />

  </div>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>MAS Bienestar</h3>
        <p>Transformando hogares para una vida más plena y saludable.</p>
      </div>
      
      <div class="footer-section">
        <h3>Contacto</h3>
        <p><i class="fas fa-envelope"></i> info@masbienestar.com</p>
        <p><i class="fas fa-phone"></i> (01) 234-5678</p>
        <p><i class="fas fa-map-marker-alt"></i> Av. Principal 123, Lima, Perú</p>
      </div>
      
      <div class="footer-section">
        <h3>Enlaces rápidos</h3>
        <a href="#">Políticas de privacidad</a>
        <a href="#">Términos y condiciones</a>
        <a href="#">Preguntas frecuentes</a>
        <a href="#">Soporte técnico</a>
      </div>
    </div>
    
    <div class="copyright">
      &copy; 2023 MAS Bienestar en tu hogar. Todos los derechos reservados.
    </div>
  </footer>

 <script>
  document.addEventListener('DOMContentLoaded', function() {
    const claseItems = document.querySelectorAll('.clase-item');
    const modulos = document.querySelectorAll('.modulo-item');

    // Clic en clase
    claseItems.forEach(item => {
      item.addEventListener('click', () => {
        claseItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        console.log('Clase seleccionada:', item.textContent);
      });
    });

    // Clic en módulo → redirigir
    modulos.forEach(modulo => {
      modulo.querySelector('.modulo-titulo').addEventListener('click', () => {
        const id = modulo.dataset.modulo;
        if (id === "2") {
          window.location.href = "http://127.0.0.1:8000/modules/module2";
        } else if (id === "4") {
          window.location.href = "http://127.0.0.1:8000/modules/module4";
        } else if (id === "1") {
          window.location.href = "http://127.0.0.1:8000/modules/module1";
        }
      });
    });

    // Botón marcar como completo
    const completeBtn = document.querySelector('.nav-btn:not(.outline)');
    if (completeBtn) {
      completeBtn.addEventListener('click', function() {
        const currentItem = document.querySelector('.clase-item.active');
        if (currentItem && !currentItem.querySelector('.fa-circle-check')) {
          const checkIcon = document.createElement('i');
          checkIcon.className = 'fas fa-circle-check';
          currentItem.appendChild(checkIcon);
        }

        // Redirigir al siguiente módulo real
        const currentModulo = currentItem.closest('.modulo-item');
        const nextModulo = currentModulo.nextElementSibling;
        if (nextModulo) {
          const id = nextModulo.dataset.modulo;
          if (id === "2") {
            window.location.href = "http://127.0.0.1:8000/modules/module2";
          } else if (id === "4") {
            window.location.href = "http://127.0.0.1:8000/modules/module4";
          }
        }
      });
    }
  });
</script>