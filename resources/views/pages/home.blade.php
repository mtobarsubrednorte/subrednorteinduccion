<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MAS Bienestar en tu hogar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #2A6B7E;
      --secondary: #4CAF50;
      --accent: #FF9800;
      --light: #F8F9FA;
      --dark: #343A40;
      --gray: #6C757D;
      --light-gray: #E9ECEF;
      --white: #FFFFFF;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', Arial, sans-serif;
      background-color: var(--light);
      color: var(--dark);
      line-height: 1.6;
    }
    
    /* Header */
    header {
      background: var(--white);
      padding: 15px 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .logo-container {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    header img {
      height: 50px;
    }
    
    header h1 {
      color: var(--primary);
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .usuario {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--gray);
      font-size: 0.9rem;
    }
    
    .usuario i {
      font-size: 1.2rem;
    }
    
    /* Banner */
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
    
    .banner-content {
      max-width: 600px;
    }
    
    .banner-content h2 {
      font-size: 2.2rem;
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    .banner-content p {
      font-size: 1.1rem;
      opacity: 0.9;
    }
    
    /* Main Content */
    .contenido {
      display: flex;
      padding: 30px 5%;
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    /* Navigation */
    .navegacion {
      width: 22%;
      background: var(--white);
      padding: 20px;
      border-radius: 10px;
      box-shadow: var(--shadow);
      height: fit-content;
    }
    
    .navegacion h3 {
      color: var(--primary);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-gray);
      font-weight: 600;
    }
    
    .navegacion ul {
      list-style: none;
      padding: 0;
    }
    
    .navegacion > ul > li {
      margin: 12px 0;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      padding: 8px 10px;
      border-radius: 6px;
    }
    
    .navegacion > ul > li:hover {
      background-color: var(--light-gray);
      color: var(--primary);
    }
    
    .navegacion ul ul {
      margin-left: 15px;
      border-left: 2px solid var(--light-gray);
      padding-left: 15px;
    }
    
    .navegacion ul ul li {
      margin: 10px 0;
      font-size: 0.9rem;
      font-weight: 400;
      color: var(--gray);
      cursor: pointer;
      transition: var(--transition);
      padding: 5px 8px;
      border-radius: 4px;
    }
    
    .navegacion ul ul li:hover {
      color: var(--primary);
      background-color: var(--light-gray);
    }
    
    .navegacion ul ul li:before {
      content: "•";
      margin-right: 5px;
      color: var(--secondary);
    }
    
    /* Principal Content */
    .principal {
      width: 56%;
    }
    
    .principal > p {
      margin-bottom: 25px;
      font-size: 1.1rem;
      background: var(--white);
      padding: 15px 20px;
      border-radius: 8px;
      box-shadow: var(--shadow);
    }
    
    .principal > p strong {
      color: var(--primary);
    }
    
    .cursos {
      display: flex;
      gap: 20px;
      margin: 25px 0;
      flex-wrap: wrap;
    }
    
    .curso-card {
      flex: 1;
      min-width: 180px;
      background: var(--white);
      padding: 25px 20px;
      border-radius: 10px;
      box-shadow: var(--shadow);
      text-align: center;
      transition: var(--transition);
      cursor: pointer;
      border: 2px solid transparent;
    }
    
    .curso-card:hover {
      transform: translateY(-5px);
      border-color: var(--primary);
    }
    
    .curso-card i {
      font-size: 2.5rem;
      margin-bottom: 15px;
      color: var(--primary);
    }
    
    .curso-card h3 {
      font-size: 1rem;
      color: var(--dark);
      margin-bottom: 10px;
    }
    
    .curso-card p {
      font-size: 0.85rem;
      color: var(--gray);
    }
    
    .informacion {
      background: var(--white);
      padding: 25px;
      border-radius: 10px;
      box-shadow: var(--shadow);
      margin-top: 20px;
    }
    
    .informacion h2 {
      color: var(--primary);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-gray);
      font-weight: 600;
    }
    
    .informacion p {
      color: var(--gray);
      line-height: 1.8;
    }
    
    /* Lateral */
    .lateral {
      width: 22%;
      background: var(--white);
      padding: 25px;
      border-radius: 10px;
      box-shadow: var(--shadow);
      height: fit-content;
    }
    
    .lateral h3 {
      color: var(--primary);
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
    }
    
    .lateral label {
      display: block;
      margin: 15px 0 8px;
      color: var(--gray);
      font-size: 0.9rem;
    }
    
    .lateral input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--light-gray);
      border-radius: 6px;
      font-size: 0.9rem;
      transition: var(--transition);
    }
    
    .lateral input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(42, 107, 126, 0.1);
    }
    
    .lateral button {
      width: 100%;
      padding: 12px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 6px;
      margin-top: 15px;
      cursor: pointer;
      font-weight: 500;
      transition: var(--transition);
    }
    
    .lateral button:hover {
      background: #235766;
    }
    
    .avatar {
      text-align: center;
      margin-top: 25px;
    }
    
    .avatar img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--light-gray);
    }
    
    .avatar p {
      margin-top: 10px;
      font-size: 0.9rem;
      color: var(--gray);
    }
    
    /* Footer */
    footer {
      background: var(--dark);
      color: var(--white);
      padding: 30px 5%;
      margin-top: 50px;
    }
    
    .footer-content {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .footer-section {
      flex: 1;
      min-width: 250px;
    }
    
    .footer-section h3 {
      font-size: 1.2rem;
      margin-bottom: 20px;
      color: var(--secondary);
    }
    
    .footer-section p, .footer-section a {
      color: #CCC;
      margin-bottom: 10px;
      display: block;
      text-decoration: none;
      transition: var(--transition);
    }
    
    .footer-section a:hover {
      color: var(--white);
    }
    
    .copyright {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: #AAA;
      font-size: 0.9rem;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
      .contenido {
        flex-wrap: wrap;
      }
      
      .navegacion, .principal, .lateral {
        width: 100%;
      }
      
      .navegacion {
        order: 1;
      }
      
      .principal {
        order: 3;
      }
      
      .lateral {
        order: 2;
      }
    }
    
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }
      
      .logo-container {
        flex-direction: column;
      }
      
      .banner-content h2 {
        font-size: 1.8rem;
      }
      
      .cursos {
        flex-direction: column;
      }
      
      .curso-card {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo-container">
      <img src="{{ asset('images/logos/Logo_entorno.jpg') }}" alt="Logo MAS Bienestar">
      <h1>MAS Bienestar en tu hogar</h1>
    </div>
    <div class="usuario">
      <i class="fas fa-user-circle"></i>
      <span>NOMBRE DEL COLABORADOR</span>
    </div>
    <div>
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" style="background:none; border:none; color:var(--primary); cursor:pointer; font-weight:500;">Cerrar sesión <i class="fas fa-sign-out-alt"></i></button>
      </form>

    </div>
  </header>

  <div class="banner">
    <div class="banner-content">
      <h2>Bienestar integral para tu familia</h2>
      <p>Descubre nuestros cursos diseñados para mejorar tu calidad de vida y bienestar en el hogar.</p>
    </div>
  </div>

  <div class="contenido">
    <!-- Navegación -->
    <aside class="navegacion">
      <h3><i class="fas fa-bars"></i> NAVEGACIÓN</h3>
      <ul>
        <li><i class="fas fa-home"></i> Página Principal</li>
        <li><i class="fas fa-user"></i> Área personal</li>
        <li><i class="fas fa-sitemap"></i> Páginas del sitio</li>
        <li><i class="fas fa-graduation-cap"></i> Cursos</li>
        <ul>
          <li>Inducción_septiembre_2025</li>
          <li>ICS_1</li>
          <li>GCS_julio_2025</li>
          <li>gompi_2025</li>
        </ul>
        <li><i class="fas fa-chart-line"></i> IE</li>
      </ul>
    </aside>

    <!-- Contenido principal -->
    <main class="principal">
      <p><strong>Inscripción a los cursos virtuales</strong> de la estrategia + <b>MAS Bienestar</b> para tu hogar</p>
      
      <div class="cursos">
        <div class="curso-card">
          <i class="fas fa-book-open"></i>
          <h3>CURSO DE INDUCCIÓN</h3>
          <p>Conoce los fundamentos de bienestar en el hogar</p>
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
      
      <div class="avatar">
        <img src="avatar.png" alt="Avatar">
        <p>Área de verificación</p>
      </div>
    </aside>
  </div>

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
      &copy; 2023 MAS Bienestar en tu hogar. Todos los derechos reservados.
    </div>
  </footer>

</body>
</html>