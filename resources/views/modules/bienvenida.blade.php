@extends('layouts.app')

@section('content')
<div class="container py-4 bienvenida-bg" style="background-image: url('{{ asset('images/imagen_entorno.jpg') }}'); background-size: cover; background-position: center; border-radius: 8px; padding: 30px;">

    <!-- Botones de navegación entre módulos -->
    <div class="mb-4 d-flex justify-content-end gap-2">
        <a href="{{ route('modules.bienvenida') }}" class="btn btn-primary">Bienvenida</a>
        <a href="{{ route('modules.gestion_territorial') }}" class="btn btn-primary">Gestión Territorial</a>
    </div>

    <h1 class="mb-4 text-center text-white">{{ $module->title }}</h1>

    <!-- Barra de progreso -->
    <div class="progress mb-4" style="height: 30px;">
        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
             role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            0%
        </div>
    </div>

    <!-- Video local -->
    <div class="mb-5" style="text-align:center;">
        <video id="bienvenidaVideo" width="100%" controls style="max-width:800px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.2);">
            <source src="{{ asset('videos/MAS_Bienestar_video.mp4') }}" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>

    <!-- Plantilla Genially -->
    <div id="geniallyContainer" class="container-wrapper-genially" style="position: relative; min-height: 400px; max-width: 100%; margin: 0 auto;">
        <video class="loader-genially" autoplay loop playsinline muted
            style="position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; margin-bottom: 10%;">
            <source src="https://static.genially.com/resources/loader-default-rebranding.mp4" type="video/mp4" />
            Tu navegador no soporta el video.
        </video>
        <div id="68913d5fcb9d97c53e1192d6" class="genially-embed" style="margin: 0 auto; position: relative; height: auto; width: 100%;"></div>
    </div>

    <!-- Mensaje de completado -->
    <div id="completadoMessage" class="alert alert-success mt-4 text-center" style="display:none;">
        🎉 ¡Has completado el módulo!
    </div>

    <!-- Botón Siguiente -->
    <div class="mt-4 text-center">
        <a href="{{ route('modules.gestion_territorial') }}" class="btn btn-success btn-lg">Siguiente</a>
    </div>

</div>

<script>
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

    let video = document.getElementById('bienvenidaVideo');
    let progressBar = document.getElementById('progressBar');

    let videoProgress = 0;
    let geniallyProgress = 0;
    let completadoEnviado = false;

    video.addEventListener('timeupdate', function() {
        videoProgress = (video.currentTime / video.duration) * 50;
        actualizarBarra();
    });

    // Simular Genially completado después de 3s
    setTimeout(() => {
        geniallyProgress = 50;
        actualizarBarra();
    }, 3000);

    function actualizarBarra() {
        let totalProgress = videoProgress + geniallyProgress;
        if(totalProgress > 100) totalProgress = 100;

        progressBar.style.width = totalProgress + '%';
        progressBar.setAttribute('aria-valuenow', totalProgress);
        progressBar.innerText = Math.round(totalProgress) + '%';

        if(totalProgress >= 100 && !completadoEnviado) {
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
        .then(response => response.json())
        .then(data => {
            document.getElementById('completadoMessage').style.display = 'block';
        })
        .catch(err => console.error('Error al marcar completado:', err));
    }
});
</script>

<style>
@media (max-width: 768px) {
    .genially-embed {
        height: 300px !important;
    }
    video {
        height: auto;
    }
}
</style>
@endsection