<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Módulos de Clases - MAS Bienestar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #2A6B7E;
      --secondary: #4CAF50;
      --accent: #FF9800;
      --light: #F8F9FA;
      --dark: #343A40;
      --gray: #6C757D;
      --light-gray: #E9ECEF;
      --white: #FFFFFF;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', Arial, sans-serif;
      background-color: var(--light);
      color: var(--dark);
      line-height: 1.6;
    }
    
    /* Header */
    header {
      background: var(--white);
      padding: 15px 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .logo-container {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    header img {
      height: 50px;
    }
    
    header h1 {
      color: var(--primary);
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .usuario {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--gray);
      font-size: 0.9rem;
    }
    
    .usuario i {
      font-size: 1.2rem;
    }
    
    /* Breadcrumb */
    .breadcrumb {
      padding: 15px 5%;
      background: var(--white);
      border-bottom: 1px solid var(--light-gray);
      font-size: 0.9rem;
    }
    
    .breadcrumb a {
      color: var(--gray);
      text-decoration: none;
      transition: var(--transition);
    }
    
    .breadcrumb a:hover {
      color: var(--primary);
    }
    
    .breadcrumb span {
      color: var(--gray);
      margin: 0 8px;
    }
    
    /* Main Content */
    .contenido-modulo {
      display: flex;
      padding: 30px 5%;
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    /* Navigation */
    .navegacion-modulos {
      width: 25%;
      background: var(--white);
      padding: 20px;
      border-radius: 10px;
      box-shadow: var(--shadow);
      height: fit-content;
      max-height: 80vh;
      overflow-y: auto;
    }
    
    .navegacion-modulos h3 {
      color: var(--primary);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-gray);
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .modulo-item {
      margin-bottom: 15px;
      border-left: 3px solid var(--light-gray);
      padding-left: 15px;
    }
    
    .modulo-titulo {
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: var(--transition);
    }
    
    .modulo-titulo:hover {
      color: #235766;
    }
    
    .clase-list {
      list-style: none;
      margin-left: 10px;
      border-left: 2px solid var(--light-gray);
      padding-left: 15px;
      margin-top: 8px;
      margin-bottom: 15px;
    }
    
    .clase-item {
      padding: 10px 0;
      border-bottom: 1px solid var(--light-gray);
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .clase-item:hover {
      color: var(--primary);
    }
    
    .clase-item.active {
      color: var(--primary);
      font-weight: 500;
    }
    
    .clase-item.active i {
      color: var(--secondary);
    }
    
    .clase-item i.fa-circle-check {
      color: var(--secondary);
      margin-left: auto;
    }
    
    /* Contenido principal del módulo */
    .contenido-principal-modulo {
      width: 75%;
      background: var(--white);
      border-radius: 10px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }
    
    .modulo-header {
      padding: 20px 25px;
      background: linear-gradient(to right, var(--primary), #3a89a0);
      color: white;
    }
    
    .modulo-header h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }
    
    .modulo-header p {
      opacity: 0.9;
    }
    
    .modulo-progress {
      background: var(--light);
      padding: 12px 25px;
      display: flex;
      align-items: center;
      gap: 15px;
      border-bottom: 1px solid var(--light-gray);
    }
    
    .progress-text {
      font-size: 0.9rem;
      color: var(--gray);
    }
    
    .progress-bar {
      flex: 1;
      height: 8px;
      background: var(--light-gray);
      border-radius: 4px;
      overflow: hidden;
    }
    
    .progress-fill {
      height: 100%;
      background: var(--secondary);
      border-radius: 4px;
      width: 65%;
    }
    
    /* Contenedor Genially */
    .genially-container {
      position: relative;
      padding-bottom: 56.25%; /* Relación de aspecto 16:9 */
      height: 0;
      overflow: hidden;
      background: #f1f1f1;
    }
    
    .genially-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
    }
    
    /* Navegación entre clases */
    .clase-navigation {
      display: flex;
      justify-content: space-between;
      padding: 20px 25px;
      border-top: 1px solid var(--light-gray);
    }
    
    .nav-btn {
      padding: 10px 20px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 500;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .nav-btn:hover {
      background: #235766;
    }
    
    .nav-btn.outline {
      background: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
    }
    
    .nav-btn.outline:hover {
      background: var(--light);
    }
    
    /* Información de la clase */
    .clase-info {
      padding: 20px 25px;
      border-bottom: 1px solid var(--light-gray);
    }
    
    .clase-info h3 {
      color: var(--primary);
      margin-bottom: 15px;
      font-size: 1.3rem;
    }
    
    .clase-meta {
      display: flex;
      gap: 20px;
      margin-bottom: 15px;
      font-size: 0.9rem;
      color: var(--gray);
    }
    
    .meta-item {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .clase-descripcion {
      line-height: 1.7;
    }
    
    /* Recursos adicionales */
    .recursos {
      padding: 20px 25px;
    }
    
    .recursos h3 {
      color: var(--primary);
      margin-bottom: 15px;
      font-size: 1.2rem;
    }
    
    .recurso-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .recurso-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 15px;
      background: var(--light);
      border-radius: 5px;
      transition: var(--transition);
      cursor: pointer;
    }
    
    .recurso-item:hover {
      background: var(--light-gray);
    }
    
    .recurso-icon {
      width: 40px;
      height: 40px;
      background: var(--primary);
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }
    
    .recurso-info {
      flex: 1;
    }
    
    .recurso-info h4 {
      font-size: 0.95rem;
      margin-bottom: 3px;
    }
    
    .recurso-info p {
      font-size: 0.8rem;
      color: var(--gray);
    }
    
    .recurso-download {
      color: var(--primary);
      font-size: 1.2rem;
    }
    
    /* Footer */
    footer {
      background: var(--dark);
      color: var(--white);
      padding: 30px 5%;
      margin-top: 50px;
    }
    
    .footer-content {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .footer-section {
      flex: 1;
      min-width: 250px;
    }
    
    .footer-section h3 {
      font-size: 1.2rem;
      margin-bottom: 20px;
      color: var(--secondary);
    }
    
    .footer-section p, .footer-section a {
      color: #CCC;
      margin-bottom: 10px;
      display: block;
      text-decoration: none;
      transition: var(--transition);
    }
    
    .footer-section a:hover {
      color: var(--white);
    }
    
    .copyright {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: #AAA;
      font-size: 0.9rem;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
      .contenido-modulo {
        flex-wrap: wrap;
      }
      
      .navegacion-modulos, .contenido-principal-modulo {
        width: 100%;
      }
    }
    
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }
      
      .logo-container {
        flex-direction: column;
      }
      
      .clase-navigation {
        flex-direction: column;
        gap: 10px;
      }
      
      .nav-btn {
        width: 100%;
        justify-content: center;
      }
      
      .clase-meta {
        flex-wrap: wrap;
      }
    }
  </style>
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
    <a href="#">Inicio</a>
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
            <i class="fas fa-play-circle"></i> ¿Qué es el bienestar integral?
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Pilares del bienestar
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
      
      <div class="modulo-item">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 3: Bienestar emocional
        </div>
        <ul class="clase-list">
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Introducción
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Manejo del estrés
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Mindfulness
          </li>
        </ul>
      </div>
      
      <div class="modulo-item">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 4: Entorno saludable
        </div>
        <ul class="clase-list">
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Espacios saludables
          </li>
          <li class="clase-item">
            <i class="fas fa-play-circle"></i> Relaciones interpersonales
          </li>
        </ul>
      </div>
    </aside>

    <!-- Contenido principal del módulo -->
    <main class="contenido-principal-modulo">
      <div class="modulo-header">
        <h2>Módulo 1: Introducción al bienestar</h2>
        <p>Descubre los fundamentos del bienestar integral y su importancia en la vida cotidiana</p>
      </div>
      
      <div class="modulo-progress">
        <div class="progress-text">Progreso del módulo: 65%</div>
        <div class="progress-bar">
          <div class="progress-fill"></div>
        </div>
      </div>
      
      <div class="clase-info">
        <h3>Bienvenida al curso</h3>
        <div class="clase-meta">
          <div class="meta-item">
            <i class="far fa-clock"></i> Duración: 25 min
          </div>
          <div class="meta-item">
            <i class="far fa-check-circle"></i> Completado
          </div>
          <div class="meta-item">
            <i class="fas fa-trophy"></i> 10 puntos
          </div>
        </div>
        <div class="clase-descripcion">
          <p>En esta clase introductoria, conocerás los objetivos del curso, la metodología de trabajo y los beneficios que obtendrás al completar toda la formación en bienestar integral para tu hogar.</p>
        </div>
      </div>
      
      <!-- Contenedor para Genially -->
      <div class="genially-container">
            <video class="loader-genially" autoplay loop playsinline muted
                style="position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; margin-bottom: 10%;">
                <source src="https://static.genially.com/resources/loader-default-rebranding.mp4" type="video/mp4" />
                Tu navegador no soporta el video.
            </video>
            <div id="68913d5fcb9d97c53e1192d6" class="genially-embed" style="margin: 0 auto; position: relative; height: auto; width: 100%;"></div>

      </div>

      <!-- Recursos adicionales -->
      <div class="recursos">
        <h3><i class="fas fa-paperclip"></i> Recursos adicionales</h3>
        <div class="recurso-list">
          <div class="recurso-item">
            <div class="recurso-icon">
              <i class="fas fa-file-pdf"></i>
            </div>
            <div class="recurso-info">
              <h4>Guía de bienestar.pdf</h4>
              <p>Documento complementario con ejercicios prácticos</p>
            </div>
            <div class="recurso-download">
              <i class="fas fa-download"></i>
            </div>
          </div>
          
          <div class="recurso-item">
            <div class="recurso-icon">
              <i class="fas fa-file-alt"></i>
            </div>
            <div class="recurso-info">
              <h4>Cuestionario inicial.docx</h4>
              <p>Evalúa tu punto de partida en bienestar</p>
            </div>
            <div class="recurso-download">
              <i class="fas fa-download"></i>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Navegación entre clases -->
      <div class="clase-navigation">
        <button class="nav-btn outline">
          <i class="fas fa-chevron-left"></i> Clase anterior
        </button>
        <button class="nav-btn">
          Marcar como completado <i class="fas fa-check"></i>
        </button>
        <button class="nav-btn">
          Siguiente clase <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </main>
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
    // Funcionalidad para la navegación de clases
    document.addEventListener('DOMContentLoaded', function() {
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
      completeBtn.addEventListener('click', function() {
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

    document.addEventListener("DOMContentLoaded", function() {
        // Cargar Genially script
        (function(d) {
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

</body>
</html>