@extends('layouts.app')

@section('content')
<div class="container py-4 bienvenida-bg" 
     style="background-image: url('{{ asset('images/imagen_entorno.jpg') }}'); background-size: cover; background-position: center; border-radius: 8px; padding: 30px;">

    <!-- Contenedor con fondo oscuro semitransparente -->
    <div style="background: rgba(0,0,0,0.75); border-radius: 12px; padding: 25px; color: #fff;">

        <!-- Navegación -->
        <div class="mb-4 d-flex justify-content-end gap-2">
            <a href="{{ route('modules.bienvenida') }}" class="btn btn-primary">Bienvenida</a>
            <a href="{{ route('modules.gestion_territorial') }}" class="btn btn-primary">Gestión Territorial</a>
            <a href="{{ route('modules.aplicativo_gitapps') }}" class="btn btn-primary">Aplicativo GitApps</a>
            <a href="{{ route('modules.final') }}" class="btn btn-primary">Final</a>
        </div>

        <!-- Título -->
        <h1 class="mb-4 text-center">{{ $module->title }}</h1>

        <!-- Barra progreso -->
        <div class="progress mb-4" style="height: 30px;">
            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>

        <!-- Pasos -->
        <div class="text-center">
            <h4>Pasos del Proceso</h4>
            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                @php
                    $colors = [
                        '#007bff', '#28a745', '#ffc107', '#dc3545',
                        '#17a2b8', '#6c757d', '#343a40', '#20c997',
                        '#fd7e14', '#6610f2'
                    ];
                @endphp

                @foreach(range(1,10) as $i)
                    <button class="step-btn"
                            data-step="{{ $i }}"
                            style="width:80px; height:80px; font-size:24px; font-weight:bold; border-radius:50%; border:none; color:#fff; background:{{ $colors[$i-1] }}; transition: all 0.3s ease;">
                        {{ $i }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="stepModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Paso <span id="modalStepNumber"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body d-flex align-items-start">
                
               
                <!-- Contenido dinámico -->
                <div id="modalStepContent" class="flex-grow-1 text-center"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Completado -->
        <div id="completadoMessage" class="alert alert-success mt-4 text-center" style="display:none;">
            🎉 ¡Has completado el módulo!
        </div>

        <!-- Botón siguiente -->
        <div class="mt-4 text-center">
            <a href="{{ route('modules.final') }}" class="btn btn-success btn-lg">Siguiente</a>
        </div>
    </div>
</div>

<style>
/* 🎨 Estilos para hover en los pasos */
.step-btn:hover {
    transform: scale(1.2);
    box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.7);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let progressBar = document.getElementById('progressBar');
    let completadoEnviado = false;
    let stepsCompleted = new Set();

    const stepContents = {
        1: { type: "image", file: "{{ asset('images/gitapps/INICIO_DE_SESION.png') }}" },
        2: { type: "video", file: "{{ asset('videos/predios.mp4') }}" },
        3: { type: "video", file: "{{ asset('videos/CREACION_DE_FAMILIAS.mp4') }}" },
        4: { type: "video", file: "{{ asset('videos/caracterizacion.mp4') }}" },
        7: { type: "video", file: "{{ asset('videos/Plan_de_cuidaddo.mp4') }}" },
        8: { type: "video", file: "{{ asset('videos/Compromisos.mp4') }}" }
    };

    document.querySelectorAll('.step-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let step = this.getAttribute('data-step');
            document.getElementById('modalStepNumber').innerText = step;

            let contentDiv = document.getElementById('modalStepContent');
            contentDiv.innerHTML = "";

            if (stepContents[step]) {
                if (stepContents[step].type === "image") {
                    contentDiv.innerHTML = `<img src="${stepContents[step].file}" class="img-fluid rounded" style="max-height:400px;">`;
                } else if (stepContents[step].type === "video") {
                    contentDiv.innerHTML = `
                        <video controls class="img-fluid rounded" style="max-height:400px;">
                            <source src="${stepContents[step].file}" type="video/mp4">
                            Tu navegador no soporta videos.
                        </video>`;
                }
            } else {
                contentDiv.innerHTML = "<p>Contenido no asignado para este botón</p>";
            }

            new bootstrap.Modal(document.getElementById('stepModal')).show();
            stepsCompleted.add(step);
            actualizarBarra();
        });
    });

    function actualizarBarra() {
        let totalSteps = 10;
        let completed = stepsCompleted.size;
        let progress = (completed / totalSteps) * 100;

        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
        progressBar.innerText = Math.round(progress) + '%';

        if(progress >= 100 && !completadoEnviado) {
            completadoEnviado = true;
            marcarCompletado();
        }
    }

    function marcarCompletado() {
        fetch("{{ route('modules.complete', $module->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(() => {
            document.getElementById('completadoMessage').style.display = 'block';
        })
        .catch(err => console.error('Error al marcar completado:', err));
    }
});
</script>
@endsection