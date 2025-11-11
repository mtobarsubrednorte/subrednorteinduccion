@props(['modulos', 'certificates', 'link1' => null, 'link2' => null])


<main class="contenido-principal-modulo">
  {{-- Recorremos módulos principales --}}
  @foreach($modulos as $modulo)
    {{-- Vista del módulo principal --}}
    <div x-cloak x-show="moduloSeleccionado == {{ $modulo->id }}">
      <div class="modulo-header">
        <h2>{{ $modulo->title }}</h2>
      </div>

      <div class="clase-info">
        <div class="clase-meta">
          <div class="meta-item"><i class="far fa-clock"></i> Duración: {{ $modulo->duration ?? 'N/A' }} min</div>
        </div>
        <div class="clase-descripcion">
          <p>{{ $modulo->description }}</p>
        </div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
      </div>

      {{-- Genially si existe --}}
      @if($modulo->genilay_recursos_link1)

          <!-- Contenido Genially -->
          <div class="genially-container">
            <iframe title=".." frameborder="0" width="1200px" height="675px"
          style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
          src="{{ $modulo->genilay_recursos_link1 }}"
          type="text/html" allowscriptaccess="always" allowfullscreen="true" scrolling="yes" allownetworking="all">
        </iframe>
          </div>
       
      @endif

      {{-- Steps --}}
      @php
        $completedSteps = auth()->user()->completedSteps->pluck('id')->toArray();
        $lastCompletedIndex = -1;

        foreach ($modulo->steps as $index => $step) {
          if (in_array($step->id, $completedSteps)) {
            $lastCompletedIndex = $index;
          }
        }
      @endphp

      

      @foreach($modulo->steps as $i => $step)
        @php
          $completed = in_array($step->id, $completedSteps);
          // desbloquea si ya está completado o si es el siguiente al último completado
          $unlocked = $completed || $i === $lastCompletedIndex + 1;
        @endphp

        <div class="step {{ !$unlocked ? 'locked' : '' }} {{ $completed ? 'done' : '' }}" data-step="{{ $step->id }}">
          <div class="step-number">{{ $i + 1 }}</div>
          <i class="fas {{ $step->icon }} step-icon"></i>
          <div class="step-desc">{{ $step->text }}</div>
        </div>
      @endforeach


      @if($modulo->images->count())
        <div class="recursos">
  
          @foreach($modulo->images as $img)
            
              <div class="col-md-4 m-3">
                <p class="descripcion_img">{{ $img->description }}</p>
                <img src="{{ asset('storage/' . $img->image_path) }}" class="img_description">
              </div>    
                
          @endforeach
        </div>
      @endif

      {{-- Recursos --}}
      <div class="recursos">
        <h3><i class="fas fa-paperclip"></i> Recursos adicionales</h3>
        <div class="recurso-list">
          @forelse($modulo->recursos ?? [] as $recurso)
            <div class="recurso-item">
              <div class="recurso-icon">
                @if($recurso->file_type === 'pdf')
                  <i class="fas fa-file-pdf text-danger"></i>
                @elseif(in_array($recurso->file_type, ['doc', 'docx']))
                  <i class="fas fa-file-word text-primary"></i>
                @elseif(in_array($recurso->file_type, ['xls', 'xlsx']))
                  <i class="fas fa-file-excel text-success"></i>
                @else
                  <i class="fas fa-file text-secondary"></i>
                @endif
              </div>

              <div class="recurso-info">
                {{ $recurso->original_name ?? basename($recurso->file_path) }}
                <p>Documento complementario</p>
              </div>

              <div class="recurso-download">
                <a href="{{ Storage::url($recurso->file_path) }}" target="_blank" class="btn btn-link">
                  <i class="fas fa-download"></i> Descargar
                </a>
              </div>
            </div>
          @empty
            <p class="text-muted">No hay recursos disponibles para este módulo.</p>
          @endforelse
        </div>
      </div>

    </div>

    {{-- Vista de cada submódulo (si existen) --}}
    @foreach($modulo->submodulos ?? [] as $sub)
      <div x-cloak x-show="moduloSeleccionado == {{ $sub->id }}">
        <div class="modulo-header">
          <h2>{{ $sub->title }}</h2>
          <p>{{ $sub->description }}</p>
        </div>

        <div class="clase-info">
          <h3>{{ $sub->title }}</h3>
          <div class="clase-meta">
            <div class="meta-item"><i class="far fa-clock"></i> Duración: {{ $sub->duration ?? 'N/A' }} min</div>
          </div>
          <div class="clase-descripcion">
            <p>{{ $sub->description }}</p>
          </div>
        </div>

        {{-- recursos del submódulo --}}
        <div class="recursos">
          <ul>
            @foreach($sub->recursos ?? [] as $recurso)
              <li><a href="{{ Storage::url($recurso->file_path) }}" target="_blank">{{ basename($recurso->file_path) }}</a>
              </li>
            @endforeach
          </ul>

        </div>
      </div>
    @endforeach

    {{-- Vista examen del módulo --}}
    <div x-cloak x-show="moduloSeleccionado == 'examen-{{ $modulo->id }}'">
      <div class="modulo-header">
        <h2>Examen: {{ $modulo->title }}</h2>
      </div>

      {{-- Mostrar aquí un botón para iniciar o el formulario del examen --}}
      <div class="clase-info">

        <div class="exam-container">
          <!-- Encabezado del examen -->
          <div class=" text-center">
            <h1 class="exam-title">{{ $modulo->nombre ?? 'Examen del Módulo' }}</h1>
            <p class="exam-subtitle">Responde todas las preguntas antes de enviar el examen</p>
            <p>Este módulo tiene {{ $modulo->preguntas->count() }} preguntas.</p>

          </div>

          <!-- Barra de progreso -->
          <div class="progress-container">
            <div class="d-flex justify-content-between mb-2">
              <span>Progreso del examen</span>
              <span id="progress-text">0%</span>
            </div>
            <div class="progress">
              <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
            </div>
          </div>

          <!-- Temporizador -->
          <div class="timer-container">
            <div>
              <i class="fas fa-clock me-2"></i>
              <span class="timer" id="exam-timer">45:00</span>
            </div>
            <div class="question-counter">
              <span id="current-question">1</span> de <span
                id="total-questions">{{ count($modulo->preguntas ?? []) }}</span> preguntas
            </div>
          </div>



          <form action="{{ route('modulo.responder', $modulo->id) }}" method="POST" id="exam-form">
            @csrf

            @foreach($modulo->preguntas ?? [] as $preguntaIndex => $pregunta)
              <div class="question-card" id="question-{{ $preguntaIndex + 1 }}">
                <div class="question-header">
                  <div class="question-number">{{ $preguntaIndex + 1 }}</div>
                  <h5 class="mb-0">Pregunta {{ $preguntaIndex + 1 }}</h5>
                </div>
                <div class="question-body">
                  <p class="question-text">{{ $pregunta->pregunta }}</p>

                  @foreach($pregunta->opciones as $index => $opcion)
                    <div class="option-item" onclick="selectOption(this, {{ $pregunta->id }}, {{ $index }})">
                      <input class="option-radio" type="radio" name="respuestas[{{ $pregunta->id }}]" value="{{ $index }}"
                        id="opcion-{{ $pregunta->id }}-{{ $index }}">
                      <label class="option-label" for="opcion-{{ $pregunta->id }}-{{ $index }}">{{ $opcion }}</label>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach

            <button type="submit" class="btn submit-btn">
              <i class="fas fa-paper-plane me-2"></i> Enviar Respuestas
            </button>
          </form>
        </div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
      </div>


    </div>

    @foreach($modulo->steps as $i => $step)
      <div class="modal" id="modal-{{ $step->id }}">
        <div class="modal-content">
          <h2>Paso {{ $i + 1 }}</h2>
          <p>{{ $step['text'] }}</p>

          @if($step['type'] === 'image')
            <img src="{{ asset('storage/' . $step['file']) }}" alt="Paso {{ $i + 1 }}">
          @elseif($step['type'] === 'video')
            <video id="video-{{ $step->id }}" controls>
              <source src="{{ asset('storage/' . $step['file']) }}" type="video/mp4">
              Tu navegador no soporta video.
            </video>
          @endif

          <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal({{ $step->id }})">Cerrar</button>
            <button id="btn-complete-{{ $step->id }}" class="btn btn-primary" @if($step['type'] === 'video') disabled @endif
              onclick="completeStep({{ $step->id }})">
              Marcar como visto
            </button>
          </div>
        </div>
      </div>
    @endforeach
  @endforeach

  <!-- vista certificado -->
  <div x-cloak x-show="moduloSeleccionado == 'certificado'">
    <div class="modulo-header">
      <h2>Certificado de Finalización</h2>
    </div>

    <div class="clase-info">
      @if (!empty($certificates) && count($certificates) > 0)
      
      <p>Ya has generado un certificado previamente.</p> 

      @else
        <div class="certificate-preview">
          <div class="certifivado-text">
            <p>¡Felicidades! Has completado todos los módulos del curso.</p>
            <p>Puedes descargar tu certificado de finalización haciendo clic en el botón a continuación.</p>
          </div>

          <a href="{{ route('certificate.download') }}" 
            id="btnCertificado"
            class="btn btn-primary mt-3 btn-certifycate"
            onclick="bloquearBoton(this)">
            Generar Certificado (PDF)
          </a> 
        </div>
      @endif

    </div>
  </div>
</main>
<!-- Modales -->
<script>
  // Manejo de Escalera
  const steps = document.querySelectorAll('.step');
  steps.forEach(step => {
    step.addEventListener('click', () => {
      if (!step.classList.contains('locked')) {
        const stepNum = step.dataset.step;
        document.getElementById(`modal-${stepNum}`).classList.add('active'); // ✅ CORREGIDO
        const video = document.getElementById(`video-${stepNum}`);
        if (video) {
          video.currentTime = 0;
          video.addEventListener('ended', () => {
            document.getElementById(`btn-complete-${stepNum}`).disabled = false;
          }, { once: true });
        }
      }
    });
  });


  function closeModal(step) {
    document.getElementById(`modal-${step}`).classList.remove('active');
  }

  function completeStep(stepId) {
    const currentStep = document.querySelector(`.step[data-step="${stepId}"]`);
    currentStep.classList.add('done');
    closeModal(stepId);
    const nextStep = document.querySelector(`.step[data-step="${stepId + 1}"]`);
    if (nextStep) nextStep.classList.remove('locked');

    // Llamada al backend para guardar el progreso
    fetch('/steps/complete', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ step_id: stepId })
    }).then(res => res.json())
      .then(data => console.log('Progreso guardado:', data));
  }



  // Mostrar/Ocultar secciones dinámicas
  function mostrarSeccion(id, elemento) {
    document.querySelectorAll('.seccion-modulo').forEach(sec => sec.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    document.querySelectorAll('.clase-item').forEach(item => item.classList.remove('active'));
    elemento.classList.add('active');
  }

  // Mostrar acciones colectivas o individuales
  function mostrarAcciones(tipo) {
    document.querySelectorAll('.acciones-tab').forEach(tab => tab.style.display = 'none');
    document.getElementById(`acciones-${tipo}`).style.display = 'block';
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {

    let previousText = '';

    function checkTextChange() {
      

      const link2 = document.getElementById("input-genialy").value;

      const currentText = link2;
      // Comparar con el texto anterior
      if (currentText !== previousText) {
        // Guardar el nuevo texto como anterior para la próxima verificación
        previousText = currentText;

        // Ejecutar la función si el texto cambió
        executeFunction();
        return true;
      }

      // No hubo cambios
      return false;
    }

    //setInterval(checkTextChange, 1000);

    // Función que se ejecuta cuando el texto cambia
    function executeFunction() {
      console.log("Ejecutando función porque el texto cambió");
      const link2 = document.getElementById("input-genialy").value;
      console.log(link2);
      (function (d) {
        var js, id = "genially-embed-js", ref = d.getElementsByTagName("script")[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement("script");
        js.id = id;
        js.async = true;
        js.src = link2;
        ref.parentNode.insertBefore(js, ref);
      }(document));
    }



  });
</script>


<script>
  // Actualizar barra de progreso
  function updateProgress() {
    const totalQuestions = {{ count($modulo->preguntas ?? []) }};
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
    const progress = (answeredQuestions / totalQuestions) * 100;

    document.getElementById('progress-bar').style.width = `${progress}%`;
    document.getElementById('progress-text').textContent = `${Math.round(progress)}%`;

    // Actualizar contador de preguntas respondidas
    document.getElementById('current-question').textContent = answeredQuestions + 1;
  }

  // Seleccionar opción
  function selectOption(element, questionId, optionIndex) {
    // Desmarcar todas las opciones de esta pregunta
    const questionElement = element.closest('.question-body');
    const allOptions = questionElement.querySelectorAll('.option-item');
    allOptions.forEach(opt => opt.classList.remove('selected'));

    // Marcar la opción seleccionada
    element.classList.add('selected');

    // Marcar el radio button
    const radio = element.querySelector('input[type="radio"]');
    radio.checked = true;

    // Actualizar progreso
    updateProgress();
  }

  // Temporizador del examen (45 minutos)
  let examTime = 45 * 60; // 45 minutos en segundos
  const timerElement = document.getElementById('exam-timer');

  function updateTimer() {
    const minutes = Math.floor(examTime / 60);
    const seconds = examTime % 60;

    timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    if (examTime <= 0) {
      // Tiempo agotado, enviar formulario automáticamente
      document.getElementById('exam-form').submit();
    } else {
      examTime--;
    }
  }

  // Inicializar
  document.addEventListener('DOMContentLoaded', function () {
    updateProgress();
    setInterval(updateTimer, 1000);

    // Marcar opciones ya seleccionadas (si las hay)
    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
      radio.closest('.option-item').classList.add('selected');
    });
  });

  // Confirmación al enviar
  document.getElementById('exam-form').addEventListener('submit', function (e) {
    const totalQuestions = {{ count($modulo->preguntas ?? []) }};
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;

    if (answeredQuestions < totalQuestions) {
      if (!confirm(`Has respondido ${answeredQuestions} de ${totalQuestions} preguntas. ¿Estás seguro de que quieres enviar el examen?`)) {
        e.preventDefault();
      }
    }
  });
</script>


<script>
  function bloquearBoton(boton) {
    boton.classList.add('disabled');     // visualmente bloquea el botón
    boton.innerText = 'Generando...';    // cambia el texto
    boton.style.pointerEvents = 'none';  // evita clics adicionales
  }
</script>