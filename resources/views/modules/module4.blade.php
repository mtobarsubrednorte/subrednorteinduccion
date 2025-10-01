<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Módulo 4 - Aplicativo GitApps</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/modulos.css') }}">
  <style>
    /* estilos propios de la escalera */
    .staircase { display:flex; flex-direction:column; gap:1rem; margin-top:1.5rem; }
    .step {
      display:flex; align-items:center; gap:1rem;
      padding:1rem; border-radius:10px;
      background:#e0f2fe; cursor:pointer;
      transition:.3s; font-size:1rem;
      box-shadow:0 3px 6px rgba(0,0,0,0.1);
    }
    .step:hover:not(.locked) { transform:translateX(5px); }
    .step.locked { background:#e2e8f0; color:#94a3b8; cursor:not-allowed; }
    .step.done { background:#16a34a; color:#fff; }
    .step-number {
      font-weight:bold; font-size:1.1rem;
      background:#2563eb; color:#fff;
      border-radius:50%; width:35px; height:35px;
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0;
    }
    .step-icon { font-size:1.4rem; color:inherit; }
    .modal {
      display:none; position:fixed; inset:0;
      background:rgba(0,0,0,.6);
      justify-content:center; align-items:center;
      z-index:999;
    }
    .modal.active { display:flex; }
    .modal-content {
      background:#fff; padding:2rem; border-radius:12px;
      max-width:700px; width:90%;
      box-shadow:0 4px 10px rgba(0,0,0,0.2);
      animation:fadeIn .3s ease;
    }
    .modal-footer { margin-top:1rem; text-align:right; }
    .btn { padding:.6rem 1.2rem; border:none; border-radius:8px; font-weight:600; cursor:pointer; }
    .btn-primary { background:#2563eb; color:#fff; }
    .btn-primary:disabled { background:#94a3b8; cursor:not-allowed; }
    .btn-secondary { background:#94a3b8; color:#fff; }
    @keyframes fadeIn {
      from {opacity:0; transform:scale(.95);}
      to {opacity:1; transform:scale(1);}
    }
    .modal-content img, .modal-content video {
      width: 100%;
      margin-top: 15px;
      border-radius: 8px;
    }
    /* estilos cabecera de módulo */
    .modulo-header {
      background:#1e88e5;
      color:#fff;
      padding:1.5rem;
      border-radius:8px 8px 0 0;
      margin-bottom:1rem;
    }
    .modulo-header h2 { margin:0; font-size:1.5rem; }
    .modulo-header p { margin:.3rem 0 1rem; }
    .progreso { margin-top:10px; }
    .barra {
      background:#bbdefb;
      height:8px;
      border-radius:4px;
      overflow:hidden;
      margin-top:5px;
    }
    .barra-progreso {
      background:#43a047;
      height:100%;
      width:0%;
      transition:width .3s ease;
    }
    /* estilos de secciones dinámicas */
    .seccion-modulo { display:none; }
    .seccion-modulo.active { display:block; }
    .acciones-list ul { margin-left:20px; margin-bottom:10px; }
    .acciones-list strong { color:#2563eb; }
    .acciones-tabs { display:flex; gap:1rem; margin-bottom:1rem; }

    /* estilo para la imagen de Validar_evento */
    img.validar-img {
      display: block;
      margin: 0 auto 2rem auto;
      max-width: 100%;
      height: auto;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .descripcion-validar {
      font-size: 15px;
      line-height: 1.6;
      color: #333;
      margin-bottom: 1rem;
      text-align: justify;
    }
  </style>
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
      <span>{{ Auth::user()->name ?? 'Usuario' }}</span>
    </div>
  </header>

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{ asset('pages/home') }}">Inicio</a>
    <span>/</span>
    <a href="#">Cursos</a>
    <span>/</span>
    <a href="#">Inducción Septiembre 2025</a>
    <span>/</span>
    <a href="#">Módulo 4: Aplicativo GitApps</a>
  </div>

  <div class="contenido-modulo">
    <!-- Navegación lateral -->
    <aside class="navegacion-modulos">
      <h3><i class="fas fa-list-ol"></i> Contenido del Curso</h3>
      <ul>
        <li><a href="{{ url('/modules/module1') }}"><i class="fas fa-folder"></i> Módulo 1: Introducción al bienestar</a></li>
        <li><a href="{{ url('/modules/module2') }}"><i class="fas fa-folder"></i> Módulo 2: Estrategias de intervención</a></li>
        <li class="active"><a href="{{ url('/modules/module4') }}"><i class="fas fa-folder-open"></i> Módulo 4: Aplicativo GitApps</a></li>
      </ul>
    </aside>

    <!-- Contenido dinámico -->
    <div class="modulo-contenido">
      
      <!-- Cabecera del módulo -->
      <div class="modulo-header">
        <h2>Módulo 4: Aplicativo GitApps</h2>
        <p>Aprende a utilizar paso a paso el aplicativo GitApps dentro del entorno de MAS Bienestar.</p>
        <div class="progreso">
          <span>Progreso del módulo: 0%</span>
          <div class="barra">
            <div class="barra-progreso" style="width:0%;"></div>
          </div>
        </div>
      </div>

      <!-- Sección Escalera -->
      <div id="escalera" class="seccion-modulo active">
        <h3>Escalera de pasos</h3>
        <p>Completa los pasos en orden. Cada paso se desbloquea solo cuando completas el anterior.</p>

        @php
          $steps = [
            ['text' => 'Ingresa al sistema GTAPS con tu usuario correspondiente', 'icon' => 'fa-right-to-bracket', 'type'=>'image', 'file'=>'images/gitapps/INICIO_DE_SESION.png'],
            ['text' => 'Verifica el estado del predio: debe estar en "Efectivo".', 'icon' => 'fa-building', 'type'=>'video', 'file'=>'videos/predios.mp4'],
            ['text' => 'Revisa la caracterización previa y evita duplicidades en ADRES.', 'icon' => 'fa-magnifying-glass', 'type'=>'video', 'file'=>'videos/predios.mp4'],
            ['text' => 'Selecciona el módulo Crear Familia y registra datos de ubicación y contacto.', 'icon' => 'fa-house', 'type'=>'video', 'file'=>'videos/caracterizacion.mp4'],
            ['text' => 'Selecciona el módulo Crear Integrante Familia y valida en ADRES.', 'icon' => 'fa-user-plus', 'type'=>null, 'file'=>null],
            ['text' => 'Selecciona el módulo Crear Caracterización Familiar (obligatorio).', 'icon' => 'fa-people-roof', 'type'=>null, 'file'=>null],
            ['text' => 'Selecciona el módulo Crear Planes de Cuidado Familiar (obligatorio).', 'icon' => 'fa-notes-medical', 'type'=>'video', 'file'=>'videos/Plan_de_cuidaddo.mp4'],
            ['text' => 'Selecciona el módulo Crear Compromisos Concertados (obligatorio).', 'icon' => 'fa-handshake', 'type'=>'video', 'file'=>'videos/Compromisos.mp4'],
            ['text' => 'Diligencia los formularios: Signos, Alertas, Tamizaje Apgar.', 'icon' => 'fa-clipboard-list', 'type'=>null, 'file'=>null],
            ['text' => 'Valida datos del usuario: Documento, Fecha de nacimiento, Sexo.', 'icon' => 'fa-id-card', 'type'=>null, 'file'=>null],
          ];
        @endphp

        <div class="staircase" id="staircase">
          @foreach($steps as $i => $step)
            <div class="step {{ $i > 0 ? 'locked' : '' }}" data-step="{{ $i+1 }}">
              <div class="step-number">{{ $i+1 }}</div>
              <i class="fas {{ $step['icon'] }} step-icon"></i>
              <div class="step-desc">{{ $step['text'] }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Sección Acciones -->
      <div id="acciones" class="seccion-modulo">
        <h3>Acciones colectivas e individuales</h3>

        <!-- Descripción antes de la imagen -->
        <p class="descripcion-validar">
          Los eventos de interés en salud pública (VSP) deben registrarse en el aplicativo GitApps conforme al perfil del colaborador que realizó la intervención. 
          Para este fin se utiliza el ícono <strong>Validar Evento</strong>, el cual permite, según el usuario autenticado, visualizar y dar seguimiento a las acciones realizadas por los profesionales en cada intervención.
        </p>

        <!-- Imagen Validar_evento -->
        <img src="{{ asset('images/gitapps/Validar_evento.jpg') }}" alt="Validar Evento" class="validar-img">

        <!-- Botones -->
        <div class="acciones-tabs">
          <button class="btn btn-primary" onclick="mostrarAcciones('colectivas')">
            <i class="fas fa-people-group"></i> Acciones Colectivas
          </button>
          <button class="btn btn-primary" onclick="mostrarAcciones('individuales')">
            <i class="fas fa-user"></i> Acciones Individuales
          </button>
        </div>

        <!-- Contenido Colectivas -->
        <div id="acciones-colectivas" class="acciones-list acciones-tab">
          <ul>
            <li><strong>AMBIENTAL</strong>  
              <ul><li>Otros casos priorizados</li></ul>
            </li>
            <li><strong>ENFERMERÍA</strong>
              <ul>
                <li>Bajo peso gestacional</li>
                <li>BPN a término</li>
                <li>BPN pretérmino</li>
                <li>Cáncer infantil</li>
                <li>Crónicos</li>
                <li>DNT aguda, moderada o severa</li>
                <li>ERA IRA</li>
                <li>Familias con gestantes</li>
                <li>Familias con menores de 5 años</li>
                <li>HB gestacional</li>
                <li>Maternas adolescentes</li>
                <li>Menores con exceso de peso</li>
                <li>Morbilidad materna extrema</li>
                <li>Obesidad gestacional</li>
                <li>Otros casos priorizados</li>
                <li>Sífilis congénita</li>
                <li>Sífilis gestacional</li>
                <li>VIH gestacional</li>
              </ul>
            </li>
            <li><strong>ODONTOLOGÍA</strong>
              <ul><li>Salud oral</li></ul>
            </li>
            <li><strong>PSICLINICOS</strong>
              <ul>
                <li>Acompañamiento psicosocial</li>
                <li>Apoyo psicológico en duelo</li>
                <li>Conducta suicida (consumado)</li>
                <li>Conducta suicida (ideación)</li>
                <li>Conducta suicida (intento)</li>
                <li>Violencia reiterada</li>
              </ul>
            </li>
            <li><strong>PSICOLOGÍA</strong>
              <ul>
                <li>Acompañamiento psicosocial</li>
                <li>Apoyo psicológico en duelo</li>
                <li>Conducta suicida (amenaza)</li>
                <li>Conducta suicida (consumado)</li>
                <li>Conducta suicida (ideación)</li>
                <li>Conducta suicida (intento)</li>
                <li>Violencia en gestantes</li>
                <li>Violencia reiterada</li>
              </ul>
            </li>
            <li><strong>TERAPEUTA</strong>
              <ul><li>Otros casos priorizados</li></ul>
            </li>
          </ul>
        </div>

        <!-- Contenido Individuales -->
        <div id="acciones-individuales" class="acciones-list acciones-tab" style="display:none;">
          <ul>
            <li>Atenciones</li>
            <li>Sesiones Colectivas</li>
            <li>Sesiones Grupales</li>
          </ul>
        </div>
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

  <!-- Modales -->
  @foreach($steps as $i => $step)
    <div class="modal" id="modal-{{ $i+1 }}">
      <div class="modal-content">
        <h2>Paso {{ $i+1 }}</h2>
        <p>{{ $step['text'] }}</p>

        @if($step['type'] === 'image')
          <img src="{{ asset($step['file']) }}" alt="Paso {{ $i+1 }}">
        @elseif($step['type'] === 'video')
          <video id="video-{{ $i+1 }}" controls>
            <source src="{{ asset($step['file']) }}" type="video/mp4">
            Tu navegador no soporta video.
          </video>
        @endif

        <div class="modal-footer">
          <button class="btn btn-secondary" onclick="closeModal({{ $i+1 }})">Cerrar</button>
          <button id="btn-complete-{{ $i+1 }}" class="btn btn-primary" 
            @if($step['type']==='video') disabled @endif 
            onclick="completeStep({{ $i+1 }})">
            Marcar como visto
          </button>
        </div>
      </div>
    </div>
  @endforeach

  <!-- Scripts -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Manejo de Escalera
      const steps = document.querySelectorAll('.step');
      steps.forEach(step => {
        step.addEventListener('click', () => {
          if (!step.classList.contains('locked')) {
            const stepNum = step.dataset.step;
            document.getElementById(`modal-${stepNum}`).classList.add('active');
            const video = document.getElementById(`video-${stepNum}`);
            if(video){
              video.currentTime = 0;
              video.addEventListener('ended', () => {
                document.getElementById(`btn-complete-${stepNum}`).disabled = false;
              }, { once: true });
            }
          }
        });
      });

      window.closeModal = function(step) {
        document.getElementById(`modal-${step}`).classList.remove('active');
      }

      window.completeStep = function(step) {
        const currentStep = document.querySelector(`.step[data-step="${step}"]`);
        currentStep.classList.add('done');
        closeModal(step);
        const nextStep = document.querySelector(`.step[data-step="${parseInt(step)+1}"]`);
        if(nextStep) nextStep.classList.remove('locked');
        const done = document.querySelectorAll('.step.done').length;
        const total = document.querySelectorAll('.step').length;
        const percent = Math.round((done/total)*100);
        document.querySelector('.progreso span').innerText = `Progreso del módulo: ${percent}%`;
        document.querySelector('.barra-progreso').style.width = `${percent}%`;
      }

      // Cambio de secciones
      window.mostrarSeccion = function(id, elemento) {
        document.querySelectorAll('.seccion-modulo').forEach(sec => sec.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        elemento.classList.add('active');
      }

      // Cambio de acciones
      window.mostrarAcciones = function(tipo) {
        if(tipo === 'colectivas') {
          document.getElementById('acciones-colectivas').style.display = 'block';
          document.getElementById('acciones-individuales').style.display = 'none';
        } else {
          document.getElementById('acciones-colectivas').style.display = 'none';
          document.getElementById('acciones-individuales').style.display = 'block';
        }
      }
    });
  </script>
</body>
</html>