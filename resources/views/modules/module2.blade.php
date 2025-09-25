<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Módulo 2 - Salud Física</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/modulos.css') }}">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo-container">
      <img src="{{ asset('images/logos/Logo_entorno.jpg') }}" alt="Logo MAS Bienestar">
      <h1>MAS Bienestar en tu hogar</h1>
    </div>
    <div class="usuario">
      <i class="fas fa-user-circle"></i>
      <!-- Mostrar nombre del usuario logueado -->
      <span>{{ Auth::user()->name }}</span>
    </div>
  </header>

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{asset('pages/home')}}">Inicio</a>
    <span>/</span>
    <a href="#">Cursos</a>
    <span>/</span>
    <a href="#">Inducción Septiembre 2025</a>
    <span>/</span>
    <a href="#">Módulo 2: Salud física</a>
  </div>

  <div class="contenido-modulo">
    <!-- Navegación de módulos -->
    <aside class="navegacion-modulos">
      <h3><i class="fas fa-list-ol"></i> Contenido del Curso</h3>
      
      <div class="modulo-item" data-modulo="1">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 1: Introducción al bienestar
        </div>
        <ul class="clase-list">
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Bienvenida al curso
            <i class="fas fa-circle-check"></i>
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Realizar Examen
          </li>
        </ul>
      </div>
      
      <div class="modulo-item active" data-modulo="2">
        <div class="modulo-titulo">
          <i class="fas fa-folder-open"></i>
          Módulo 2: Salud física
        </div>
        <ul class="clase-list">
          <li class="clase-item active">
            <i class="fas fa-play-circle"></i> Introducción
            <i class="fas fa-circle-check"></i>
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
          Módulo 4: Eventos de interés en salud pública
        </div>
      </div>
    </aside>

    <!-- Contenido principal del módulo -->
    <div class="contenido-principal-modulo">
      <div class="modulo-header">
        <h2>Módulo 2: Salud física</h2>
        <p>Explora los contenidos interactivos para comprender la importancia del cuidado físico en tu bienestar.</p>
      </div>

      <!-- Barra de progreso -->
      <div class="modulo-progress">
        <span class="progress-text">Progreso: 0%</span>
        <div class="progress-bar"><div class="progress-fill" style="width: 0%;"></div></div>
      </div>

      <!-- Contenido Genially -->
      <div class="genially-container">
        <iframe title="Gestión Territorial" frameborder="0" width="1200px" height="675px"
          style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
          src="https://view.genially.com/6893e9fda1dcf302e7411d14"
          type="text/html" allowscriptaccess="always" allowfullscreen="true" scrolling="yes" allownetworking="all">
        </iframe>
      </div>

      <!-- Navegación de clases -->
      <div class="clase-navigation">
        <button class="nav-btn outline" id="btn-anterior"><i class="fas fa-arrow-left"></i> Anterior</button>
        <button class="nav-btn" id="btn-siguiente">Siguiente <i class="fas fa-arrow-right"></i></button>
      </div>
    </div>
  </div>

  <!-- Footer -->
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
      &copy; 2025 MAS Bienestar en tu hogar. Todos los derechos reservados.
    </div>
  </footer>

  <!-- Script para navegación -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const claseItems = document.querySelectorAll('.clase-item');
      const btnAnterior = document.getElementById('btn-anterior');
      const btnSiguiente = document.getElementById('btn-siguiente');

      // Navegación de clases dentro del módulo
      claseItems.forEach(item => {
        item.addEventListener('click', () => {
          claseItems.forEach(i => i.classList.remove('active'));
          item.classList.add('active');
          console.log('Clase seleccionada:', item.textContent);
        });
      });

      // Botón anterior -> redirige a módulo 1
      btnAnterior.addEventListener('click', function() {
        window.location.href = "http://127.0.0.1:8000/modules/module1";
      });

      // Botón siguiente -> redirige a módulo 4
      btnSiguiente.addEventListener('click', function() {
        window.location.href = "http://127.0.0.1:8000/modules/module4";
      });

      // Redirección al dar clic en los títulos de los módulos
      const modulos = document.querySelectorAll('.modulo-item');
      modulos.forEach(modulo => {
        modulo.addEventListener('click', () => {
          const numeroModulo = modulo.getAttribute('data-modulo');
          window.location.href = `http://127.0.0.1:8000/modules/module${numeroModulo}`;
        });
      });
    });
  </script>
</body>
</html>