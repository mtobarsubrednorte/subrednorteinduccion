<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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

    /* navegación inferior de clases */
    .clase-navigation {
      display:flex;
      justify-content:space-between;
      gap:1rem;
      margin-top:1.25rem;
    }
    .clase-navigation .nav-btn {
      padding:.6rem 1rem;
      border-radius:8px;
      border:none;
      font-weight:600;
      cursor:pointer;
      background:#2563eb; color:#fff;
    }
    .clase-navigation .nav-btn.outline {
      background:transparent; color:#2563eb; border:2px solid #2563eb;
    }
    .clase-navigation .nav-btn[disabled] {
      opacity:.5;
      cursor:not-allowed;
    }

    /* algunas utilidades */
    .contenido-modulo { display:flex; gap:1.5rem; padding:1.5rem; }
    .navegacion-modulos { width:280px; }
    .modulo-contenido { flex:1; }
  </style>
</head>
<body>

  <!-- Header -->
  <header style="display:flex; justify-content:space-between; align-items:center; padding:16px 24px; background:#fff;">
    <div style="display:flex; align-items:center; gap:12px;">
      <img src="{{ asset('images/logos/Logo_entorno.jpg') }}" alt="Logo MAS Bienestar" style="height:48px;">
      <div>
        <h1 style="margin:0; font-size:1.1rem;">MAS Bienestar en tu hogar</h1>
      </div>
    </div>

    <div class="usuario" style="display:flex; align-items:center; gap:.5rem;">
      <i class="fas fa-user-circle" style="font-size:26px;color:#2563eb;"></i>
      <span>{{ Auth::user()->name ?? 'Usuario' }}</span>
    </div>
  </header>

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="padding:12px 24px; background:#f5f7fb;">
    <a href="{{ asset('pages/home') }}">Inicio</a> <span>/</span>
    <a href="#">Cursos</a> <span>/</span>
    <a href="#">Inducción Septiembre 2025</a> <span>/</span>
    <a href="#">Módulo 4: Aplicativo GitApps</a>
  </div>

  <div class="contenido-modulo">
    <!-- Navegación lateral -->
    <aside class="navegacion-modulos" aria-label="Contenido del curso">
      <h3><i class="fas fa-list-ol"></i> Contenido del Curso</h3>

      <div class="modulo-item" data-modulo="1">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 1: Introducción al bienestar
        </div>
      </div>

      <div class="modulo-item" data-modulo="2">
        <div class="modulo-titulo">
          <i class="fas fa-folder"></i>
          Módulo 2: Salud física
        </div>
      </div>

      <div class="modulo-item active" data-modulo="4">
        <div class="modulo-titulo">
          <i class="fas fa-folder-open"></i>
          Módulo 4: Aplicativo GitApps
        </div>
        <ul class="clase-list">
          <li class="clase-item active" onclick="mostrarSeccion('escalera', this)">
            <i class="fas fa-play-circle"></i> Escalera de pasos
          </li>
          <li class="clase-item" onclick="mostrarSeccion('acciones', this)">
            <i class="fas fa-tasks"></i> Acciones colectivas e individuales
          </li>
        </ul>
      </div>
  </aside>

    <!-- Contenido dinámico -->
    <main class="modulo-contenido" role="main">
      
      <!-- Cabecera del módulo -->
      <div class="modulo-header" role="banner">
        <h2>Módulo 4: Aplicativo GitApps</h2>
        <p>Aprende a utilizar paso a paso el aplicativo GitApps dentro del entorno de MAS Bienestar.</p>
        <div class="progreso">
          <span id="progreso-text">Progreso del módulo: 0%</span>
          <div class="barra" aria-hidden="true">
            <div id="barra-progreso" class="barra-progreso" style="width:0%;"></div>
          </div>
        </div>
      </div>

      <!-- Sección Escalera -->
      <section id="escalera" class="seccion-modulo active" aria-labelledby="escalera-h">
        <h3 id="escalera-h">Escalera de pasos</h3>
        <p>Completa los pasos en orden. Cada paso se desbloquea al marcar el anterior como visto.</p>

        @php
          $steps = [
            ['text' => 'Ingresa al sistema GTAPS con tu usuario correspondiente', 'icon' => 'fa-right-to-bracket', 'type'=>'image', 'file'=>'images/gitapps/INICIO_DE_SESION.png'],
            ['text' => 'Verifica el estado del predio:Asegúrate de que el predio esté gestionado como "Efectivo" en el sistema.
              Si el predio no se encuentra como efectivo, no se puede realizar la caracterización.', 'icon' => 'fa-building', 'type'=>'video', 'file'=>'videos/predios.mp4'],
            ['text' => 'Revisa la caracterización previa y evita duplicidades en ADRES.', 'icon' => 'fa-magnifying-glass', 'type' => 'custom', 'file' => null],
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
              <i class="fas {{ $step['icon'] }} step-icon" aria-hidden="true"></i>
              <div class="step-desc">{{ $step['text'] }}</div>
            </div>
          @endforeach
        </div>

        <!-- Navegación inferior (Anterior / Siguiente) -->
        <div class="clase-navigation" aria-hidden="false">
          <button id="btn-anterior" class="nav-btn outline">Anterior</button>
          <button id="btn-siguiente" class="nav-btn">Siguiente</button>
        </div>
      </section>

      <!-- Sección Acciones -->
      <section id="acciones" class="seccion-modulo" aria-labelledby="acciones-h">
        <h3 id="acciones-h">Acciones colectivas e individuales</h3>

        <p class="descripcion-validar">
          Los eventos de interés en salud pública (VSP) deben registrarse en el aplicativo GitApps conforme al perfil del colaborador que realizó la intervención.
          Para este fin se utiliza el ícono <strong>Validar Evento</strong>, el cual permite, según el usuario autenticado, visualizar y dar seguimiento a las acciones realizadas por los profesionales en cada intervención.
        </p>

        <img src="{{ asset('images/gitapps/Validar_evento.jpg') }}" alt="Validar Evento" class="validar-img">

        <div class="acciones-tabs" role="tablist" aria-label="Acciones">
          <button class="btn btn-primary" onclick="mostrarAcciones('colectivas')"> <i class="fas fa-people-group"></i> Acciones Colectivas</button>
          <button class="btn btn-primary" onclick="mostrarAcciones('individuales')"> <i class="fas fa-user"></i> Acciones Individuales</button>
        </div>

        <div id="acciones-colectivas" class="acciones-list acciones-tab" role="tabpanel">
          <!-- contenido existente para colectivas -->
          <ul>
            <li><strong>AMBIENTAL</strong><ul><li>Otros casos priorizados</li></ul></li>
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
            <li><strong>ODONTOLOGÍA</strong><ul><li>Salud oral</li></ul></li>
            <li><strong>PSICLINICOS</strong><ul>
                <li>Acompañamiento psicosocial</li>
                <li>Apoyo psicológico en duelo</li>
                <li>Conducta suicida (consumado)</li>
                <li>Conducta suicida (ideación)</li>
                <li>Conducta suicida (intento)</li>
                <li>Violencia reiterada</li>
              </ul></li>
            <li><strong>PSICOLOGÍA</strong><ul>
                <li>Acompañamiento psicosocial</li>
                <li>Apoyo psicológico en duelo</li>
                <li>Conducta suicida (amenaza)</li>
                <li>Conducta suicida (consumado)</li>
                <li>Conducta suicida (ideación)</li>
                <li>Conducta suicida (intento)</li>
                <li>Violencia en gestantes</li>
                <li>Violencia reiterada</li>
              </ul></li>
            <li><strong>TERAPEUTA</strong><ul><li>Otros casos priorizados</li></ul></li>
          </ul>
        </div>

        <div id="acciones-individuales" class="acciones-list acciones-tab" style="display:none;" role="tabpanel">
          <ul>
            <li>Atenciones</li>
            <li>Sesiones Colectivas</li>
            <li>Sesiones Grupales</li>
          </ul>
        </div>
      </section>

    </main>
  </div>

  <!-- Footer -->
  <footer style="padding:20px; background:#fafafa; text-align:center; margin-top:20px;">
    <div class="footer-content" style="max-width:1100px; margin:0 auto;">
      <div class="footer-section">
        <h3>MAS Bienestar</h3>
        <p>Transformando hogares para una vida más plena y saludable.</p>
      </div>
      <div style="margin-top:12px;">
        <small>&copy; 2025 MAS Bienestar en tu hogar. Todos los derechos reservados.</small>
      </div>
    </div>
  </footer>

  <!-- Modales -->
  @foreach($steps as $i => $step)
    <div class="modal" id="modal-{{ $i+1 }}" aria-hidden="true">
      <div class="modal-content" role="dialog" aria-modal="true">
        <h2>Paso {{ $i+1 }}</h2>
        <p>{{ $step['text'] }}</p>

        @if($step['type'] === 'image')
          <img src="{{ asset($step['file']) }}" alt="Paso {{ $i+1 }}">
        @elseif($step['type'] === 'video')
          <video id="video-{{ $i+1 }}" controls>
            <source src="{{ asset($step['file']) }}" type="video/mp4">
            Tu navegador no soporta video.
          </video>
        @elseif($step['type'] === 'custom')
          <div class="descripcion-validar">
            <p>• Verifica que no exista una caracterización previa creada dando click en el icono de la casita, si al darle click sale vacío puedes proceder a crear la familia en el icono +, de lo contrario verifica las familias creadas que no correspondan a la que estás abordando.</p>
            <img src="{{ asset('images/gitapps/Verificacion_caratecterizacion.JPG') }}" alt="Verificación caracterización" class="validar-img">

            <p>• Por medio del icono de la lupa que se encuentra en la parte superior, verifica que el integrante no esté creado anteriormente en el aplicativo. De estarlo, verifica en qué predio y solicita el traslado correspondiente.</p>
            <img src="{{ asset('images/gitapps/Verificacion_usuario.PNG') }}" alt="Verificación usuario" class="validar-img">
        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
      // Variables
      const steps = document.querySelectorAll('.step');
      const totalSteps = steps.length;
      const barraProgreso = document.getElementById('barra-progreso');
      const progresoText = document.getElementById('progreso-text');

      // Abrir modal al hacer click en paso (si no está locked)
      steps.forEach(stepEl => {
        stepEl.addEventListener('click', () => {
          if (!stepEl.classList.contains('locked')) {
            const stepNum = stepEl.dataset.step;
            openModal(stepNum);
          }
        });
      });

      // Inicializar listeners de videos (si existen)
      for (let i = 1; i <= totalSteps; i++) {
        const video = document.getElementById(`video-${i}`);
        if (video) {
          video.addEventListener('ended', () => {
            const btn = document.getElementById(`btn-complete-${i}`);
            if (btn) btn.disabled = false;
          }, { once: true });
        }
      }

      // Open modal
      function openModal(stepNum) {
        const m = document.getElementById(`modal-${stepNum}`);
        if (m) {
          m.classList.add('active');
          m.setAttribute('aria-hidden','false');
          // reset video to 0 if exists
          const v = document.getElementById(`video-${stepNum}`);
          if (v) { v.currentTime = 0; v.play(); }
        }
      }

      // Close modal
      window.closeModal = function(stepNum) {
        const m = document.getElementById(`modal-${stepNum}`);
        if (m) {
          m.classList.remove('active');
          m.setAttribute('aria-hidden','true');
          const v = document.getElementById(`video-${stepNum}`);
          if (v) { try { v.pause(); } catch(e){} }
        }
      };

      // Completar paso
      window.completeStep = function(stepNum) {
        const current = document.querySelector(`.step[data-step="${stepNum}"]`);
        if (!current) return;
        current.classList.add('done');
        closeModal(stepNum);

        // Desbloquear siguiente paso
        const next = document.querySelector(`.step[data-step="${Number(stepNum)+1}"]`);
        if (next) next.classList.remove('locked');

        // Actualizar progreso
        updateProgress();

        // Si todos los pasos completados -> intentar redirigir al siguiente módulo (si existe)
        const doneCount = document.querySelectorAll('.step.done').length;
        if (doneCount === totalSteps) {
          // buscar modulo actual en sidebar y redirigir al siguiente si existe
          const currentModuloEl = document.querySelector('.modulo-item.active') || document.querySelector('.modulo-item[data-modulo="4"]');
          if (currentModuloEl) {
            const nextModulo = currentModuloEl.nextElementSibling;
            if (nextModulo && nextModulo.dataset && nextModulo.dataset.modulo) {
              const id = nextModulo.dataset.modulo;
              const url = `${window.location.protocol}//${window.location.host}/modules/module${id}`;
              window.location.href = url;
            } else {
              // No hay siguiente módulo
              console.log('Módulo completado. No hay siguiente módulo en la lista.');
            }
          }
        }
      };

      // Actualiza barra y texto de progreso
      function updateProgress() {
        const doneCount = document.querySelectorAll('.step.done').length;
        const pct = Math.round((doneCount / totalSteps) * 100);
        barraProgreso.style.width = pct + '%';
        progresoText.textContent = `Progreso del módulo: ${pct}%`;
      }

      // Mostrar / ocultar secciones (escalera / acciones)
      window.mostrarSeccion = function(id, elemento) {
        document.querySelectorAll('.seccion-modulo').forEach(s => s.classList.remove('active'));
        const target = document.getElementById(id);
        if (target) target.classList.add('active');

        // marcar el li activo
        document.querySelectorAll('.clase-item').forEach(ci => ci.classList.remove('active'));
        if (elemento) elemento.classList.add('active');
      };

      // Mostrar acciones colectivas / individuales
      window.mostrarAcciones = function(tipo) {
        document.querySelectorAll('.acciones-tab').forEach(tab => tab.style.display = 'none');
        const t = document.getElementById(`acciones-${tipo}`);
        if (t) t.style.display = 'block';
      };

      // Redirecciones por click en títulos de módulos (sidebar)
      document.querySelectorAll('.navegacion-modulos .modulo-item').forEach(mod => {
        const titulo = mod.querySelector('.modulo-titulo');
        titulo && titulo.addEventListener('click', () => {
          const id = mod.dataset.modulo;
          if (!id) return;
          const url = `${window.location.protocol}//${window.location.host}/modules/module${id}`;
          window.location.href = url;
        });
      });

      // Botones anterior/siguiente funcionales (buscan prev/next en DOM de sidebar)
      const btnAnterior = document.getElementById('btn-anterior');
      const btnSiguiente = document.getElementById('btn-siguiente');

      // Identificar modulo actual en sidebar (data-modulo="4")
      const currentModuloEl = document.querySelector('.navegacion-modulos .modulo-item[data-modulo="4"]') || document.querySelector('.navegacion-modulos .modulo-item.active');

      // Configurar anterior
      if (btnAnterior) {
        if (currentModuloEl && currentModuloEl.previousElementSibling && currentModuloEl.previousElementSibling.dataset && currentModuloEl.previousElementSibling.dataset.modulo) {
          btnAnterior.addEventListener('click', () => {
            const id = currentModuloEl.previousElementSibling.dataset.modulo;
            const url = `${window.location.protocol}//${window.location.host}/modules/module${id}`;
            window.location.href = url;
          });
        } else {
          btnAnterior.disabled = true;
        }
      }

      // Configurar siguiente
      if (btnSiguiente) {
        if (currentModuloEl && currentModuloEl.nextElementSibling && currentModuloEl.nextElementSibling.dataset && currentModuloEl.nextElementSibling.dataset.modulo) {
          btnSiguiente.addEventListener('click', () => {
            const id = currentModuloEl.nextElementSibling.dataset.modulo;
            const url = `${window.location.protocol}//${window.location.host}/modules/module${id}`;
            window.location.href = url;
          });
        } else {
          // Si no hay siguiente módulo, desactivar botón
          btnSiguiente.disabled = true;
        }
      }

      // Inicializar progreso si hay pasos ya marcados al cargar (opcional)
      updateProgress();
    }); // DOMContentLoaded
  </script>
</body>
</html>