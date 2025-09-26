<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MAS Bienestar en tu hogar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <style>
    .banner {
      position: relative;
      width: 100%;
      height: 280px;
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url("{{ asset('images/backgrounds/imagen_entorno.jpg') }}") center/cover no-repeat;
      display: flex;
      align-items: center;
      color: var(--white);
      padding: 0 5%;
    }
  </style>
</head>

<body>

  <x-header />

  <div class="banner">
    <div class="banner-content">
      <h2>Bienestar integral para tu familia</h2>
      <p>Descubre nuestros cursos diseñados para mejorar tu calidad de vida y bienestar en el hogar.</p>
    </div>
  </div>

  <div class="contenido">
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


      <div class="cursos">
        <div class="curso-card">
          <a class=" category-link " href="{{ asset('modules/bienvenida') }}">
            <i class="fas fa-book-open"></i>
            <h3>MODULO DE BIENVENIDA</h3>
            <p>Conoce los fundamentos de bienestar en el hogar</p>
          </a>
        </div>

        <div class="curso-card">
          <i class="fas fa-heart"></i>
          <h3>CURSO DE SALUD</h3>
          <p>Aprende sobre cuidado preventivo y salud familiar</p>
        </div>
        <div class="curso-card">
          <i class="fas fa-hand-holding-heart"></i>
          <h3>CURSO DE BIENESTAR</h3>
          <p>Mejora la calidad de vida de tu familia</p>
        </div>
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

  <x-footer />

  <x-avatar />
</body>

</html>