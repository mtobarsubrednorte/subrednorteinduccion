@extends('layouts.app')



@section('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">

@endsection

@section('content')
  <!-- Navegación -->
  {{-- <x-navegacion :cursos="$cursos" /> --}}
  <x-navegacion />

  <!-- Contenido principal -->
  <main class="principal">
    <p><strong>Cursos virtuales</strong> de la estrategia + <b>MAS Bienestar</b> para tu hogar</p>

    {{-- agrgar video de bienvenida --}}
    <div class="mb-5" style="text-align:center;">
      <video id="bienvenidaVideo" width="100%" controls autoplay muted
        style="max-width:800px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.2);">
        <source src="{{ asset('videos/MAS_Bienestar_video.mp4') }}" type="video/mp4">
        Tu navegador no soporta el video.
      </video>
    </div>

    <div class="informacion">
      <h2><i class="fas fa-info-circle"></i> Información importante</h2>
      <p>
        Los cursos de la estrategia MAS Bienestar para tu hogar están diseñados para brindarte herramientas
        prácticas que mejoren la calidad de vida de tu familia. Al inscribirte, tendrás acceso a materiales
        exclusivos, sesiones virtuales con expertos y una comunidad de apoyo. Nuestros programas se actualizan
        constantemente para brindarte la información más relevante y útil para tu día a día.
      </p>
      <p style="margin-top: 15px;">
        Todos los cursos son virtuales y puedes acceder a ellos las 24 horas del día, adaptándose a tu
        disponibilidad de tiempo. Al completar satisfactoriamente cada curso, recibirás un certificado
        que avala tus nuevos conocimientos.
      </p>
    </div>
  </main>

  <!-- Lateral -->
  <aside class="lateral">
    <h3><i class="fas fa-certificate"></i> Verifique su certificado</h3>
    <label for="doc">Número de documento</label>
    <input type="text" id="doc" name="doc" placeholder="Ej: 12345678">

    <button>Verificar ahora</button>

  </aside>
  </div>

@endsection