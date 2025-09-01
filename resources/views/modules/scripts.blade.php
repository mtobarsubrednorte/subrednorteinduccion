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

    let video = document.getElementById('moduleVideo');
    let progressBar = document.getElementById('progressBar');

    let videoProgress = 0;
    let geniallyProgress = 0;
    let completadoEnviado = false;

    if(video) {
        video.addEventListener('timeupdate', function() {
            videoProgress = (video.currentTime / video.duration) * 50;
            actualizarBarra();
        });
    }

    // Simular Genially completado
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
        .then(() => {
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