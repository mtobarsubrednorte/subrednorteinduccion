@props(['modulos', 'link1' => null, 'link2' => null])


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

        @if($modulo->id != 2)

          <input type="text" id="input-genialy" value="{{ $modulo->genilay_recursos_link2 }}" hidden>

          <div class="genially-container">
            <video class="loader-genially" autoplay loop playsinline muted
              style="position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; margin-bottom: 10%;">
              <source src="{{ $link1 }}" type="video/mp4" />
              Tu navegador no soporta el video.
            </video>
            <div id="68913d5fcb9d97c53e1192d6" class="genially-embed"
              style="margin: 0 auto; position: relative; height: auto; width: 100%;"></div>

          </div>

        @else
          <!-- Contenido Genially -->
          <div class="genially-container">
            <iframe title="Gestión Territorial" frameborder="0" width="1200px" height="675px"
              style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
              src="https://view.genially.com/6893e9fda1dcf302e7411d14" type="text/html" allowscriptaccess="always"
              allowfullscreen="true" scrolling="yes" allownetworking="all">
            </iframe>
          </div>
        @endif
      @endif

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
        <p>Este módulo tiene {{ $modulo->preguntas->count() }} preguntas.</p>

        <form action="{{ route('modulo.responder', $modulo->id) }}" method="POST">
          @csrf

          @foreach($modulo->preguntas ?? [] as $pregunta)
            <div class="pregunta mb-4">
              <p><strong>{{ $pregunta->pregunta }} ?</strong></p>

              @foreach($pregunta->opciones as $index => $opcion)
                <div>
                  <label>
                    <input type="radio" name="respuestas[{{ $pregunta->id }}]" value="{{ $index }}">
                    {{ $opcion }}
                  </label>
                </div>
              @endforeach
            </div>
          @endforeach

          <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
        </form>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
      </div>


    </div>
  @endforeach

  <!-- vista certificado -->
  <div x-cloak x-show="moduloSeleccionado == 'certificado'">
    <div class="modulo-header">
      <h2>Certificado de Finalización</h2>
    </div>

    <div class="clase-info">
      <p>¡Felicidades! Has completado todos los módulos del curso.</p>
      <p>Puedes descargar tu certificado de finalización haciendo clic en el botón a continuación.</p>

      <a href="#" class="btn btn-success">
        <i class="fas fa-certificate"></i> Descargar Certificado
      </a>
    </div>

</main>

<!-- Modales -->
@foreach($modulo->steps as $i => $step)
  <div class="modal" id="modal-{{ $i + 1 }}">
    <div class="modal-content">
      <h2>Paso {{ $i + 1 }}</h2>
      <p>{{ $step['text'] }}</p>

      @if($step['type'] === 'image')
        <img src="{{ asset($step['file']) }}" alt="Paso {{ $i + 1 }}">
      @elseif($step['type'] === 'video')
        <video id="video-{{ $i + 1 }}" controls>
          <source src="{{ asset($step['file']) }}" type="video/mp4">
          Tu navegador no soporta video.
        </video>
      @endif

      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal({{ $i + 1 }})">Cerrar</button>
        <button id="btn-complete-{{ $i + 1 }}" class="btn btn-primary" @if($step['type'] === 'video') disabled @endif
          onclick="completeStep({{ $i + 1 }})">
          Marcar como visto
        </button>
      </div>
    </div>
  </div>
@endforeach

<script>
  // Manejo de Escalera
  const steps = document.querySelectorAll('.step');
  steps.forEach(step => {
    step.addEventListener('click', () => {
      if (!step.classList.contains('locked')) {
        const stepNum = step.dataset.step;
        document.getElementById(`modal-${stepNum}`).classList.add('active');
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
      console.log("verificar texto")

      const link2 = document.getElementById("input-genialy").value;


      const currentText = link2;
      // Comparar con el texto anterior
      if (currentText !== previousText) {
        console.log("Texto cambió:", previousText, "→", currentText);

        // Guardar el nuevo texto como anterior para la próxima verificación
        previousText = currentText;

        // Ejecutar la función si el texto cambió
        executeFunction();
        return true;
      }

      // No hubo cambios
      return false;
    }

    setInterval(checkTextChange, 1000);

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