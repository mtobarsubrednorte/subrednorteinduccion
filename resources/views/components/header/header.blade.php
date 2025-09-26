<head>
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>

<header>
  <div class="logo-container">
    <img src="{{ asset('images/logos/Logo_entorno.jpg') }}" alt="Logo MAS Bienestar">
    <h1>MAS Bienestar en tu hogar</h1>
  </div>
  <div class="usuario">
    <i class="fas fa-user-circle"></i>
    <span>{{ Auth::user()->name }}</span>
  </div>
  <div>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit"
        style="background:none; border:none; color:var(--primary); cursor:pointer; font-weight:500;">Cerrar sesión <i
          class="fas fa-sign-out-alt"></i></button>
    </form>

  </div>
</header>