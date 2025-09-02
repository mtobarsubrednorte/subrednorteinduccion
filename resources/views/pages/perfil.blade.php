<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario - MAS Bienestar</title>
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
      height: 180px;
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
      font-size: 2rem;
      margin-bottom: 10px;
      font-weight: 600;
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
    
    /* Profile Content */
    .perfil-principal {
      width: 78%;
      background: var(--white);
      border-radius: 10px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }
    
    .profile-header {
      background: linear-gradient(to right, var(--primary), #3a89a0);
      padding: 25px;
      color: white;
      display: flex;
      align-items: center;
      gap: 20px;
    }
    
    .profile-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 4px solid rgba(255, 255, 255, 0.3);
      overflow: hidden;
    }
    
    .profile-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .profile-info h2 {
      font-size: 1.8rem;
      margin-bottom: 5px;
    }
    
    .profile-info p {
      opacity: 0.9;
      font-size: 1rem;
    }
    
    .profile-stats {
      display: flex;
      background: var(--light);
      padding: 15px 25px;
      justify-content: space-around;
      border-bottom: 1px solid var(--light-gray);
    }
    
    .stat {
      text-align: center;
    }
    
    .stat-number {
      font-size: 1.8rem;
      font-weight: 600;
      color: var(--primary);
    }
    
    .stat-label {
      font-size: 0.9rem;
      color: var(--gray);
    }
    
    .profile-content {
      padding: 25px;
    }
    
    .profile-tabs {
      display: flex;
      border-bottom: 2px solid var(--light-gray);
      margin-bottom: 25px;
    }
    
    .tab {
      padding: 12px 25px;
      cursor: pointer;
      font-weight: 500;
      color: var(--gray);
      transition: var(--transition);
      position: relative;
    }
    
    .tab.active {
      color: var(--primary);
      font-weight: 600;
    }
    
    .tab.active:after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--primary);
    }
    
    .tab:hover {
      color: var(--primary);
    }
    
    .tab-content {
      display: none;
    }
    
    .tab-content.active {
      display: block;
    }
    
    .info-group {
      margin-bottom: 20px;
    }
    
    .info-group h3 {
      font-size: 1.1rem;
      color: var(--primary);
      margin-bottom: 10px;
      padding-bottom: 5px;
      border-bottom: 1px solid var(--light-gray);
    }
    
    .info-item {
      display: flex;
      margin-bottom: 15px;
    }
    
    .info-label {
      width: 180px;
      font-weight: 500;
      color: var(--gray);
    }
    
    .info-value {
      flex: 1;
    }
    
    .edit-btn {
      background: var(--primary);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 500;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    
    .edit-btn:hover {
      background: #235766;
    }
    
    .courses-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    
    .course-card {
      background: var(--light);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
    }
    
    .course-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .course-img {
      height: 140px;
      background: linear-gradient(to right, #3a89a0, var(--primary));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 2.5rem;
    }
    
    .course-content {
      padding: 15px;
    }
    
    .course-title {
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--dark);
    }
    
    .course-progress {
      margin: 15px 0;
    }
    
    .progress-bar {
      height: 8px;
      background: var(--light-gray);
      border-radius: 4px;
      overflow: hidden;
    }
    
    .progress-fill {
      height: 100%;
      background: var(--secondary);
      border-radius: 4px;
    }
    
    .progress-text {
      display: flex;
      justify-content: space-between;
      font-size: 0.85rem;
      color: var(--gray);
      margin-top: 5px;
    }
    
    .course-btn {
      display: block;
      width: 100%;
      padding: 8px;
      text-align: center;
      background: var(--primary);
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 0.9rem;
      transition: var(--transition);
    }
    
    .course-btn:hover {
      background: #235766;
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
      
      .navegacion, .perfil-principal {
        width: 100%;
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
      
      .profile-header {
        flex-direction: column;
        text-align: center;
      }
      
      .profile-stats {
        flex-wrap: wrap;
        gap: 15px;
      }
      
      .info-item {
        flex-direction: column;
        margin-bottom: 20px;
      }
      
      .info-label {
        width: 100%;
        margin-bottom: 5px;
      }
      
      .profile-tabs {
        overflow-x: auto;
        white-space: nowrap;
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
      <span>{{ Auth::user()->name }}</span>
    </div>
  </header>

  <div class="banner">
    <div class="banner-content">
      <h2>Mi Perfil de Usuario</h2>
      <p>Gestiona tu información y revisa tu progreso en los cursos</p>
    </div>
  </div>

  <div class="contenido">
    <!-- Navegación -->
    <x-navegacion />

    <!-- Contenido principal del perfil -->
    <main class="perfil-principal">
      <div class="profile-header">
        <div class="profile-avatar">
          <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Avatar usuario">
        </div>
        <div class="profile-info">
          <h2>{{ Auth::user()->name }}</h2>
          <p>Colaboradora desde: Enero 2023</p>
        </div>
      </div>
      
      <div class="profile-stats">
        <div class="stat">
          <div class="stat-number">4</div>
          <div class="stat-label">Cursos Inscritos</div>
        </div>
        <div class="stat">
          <div class="stat-number">2</div>
          <div class="stat-label">Cursos Completados</div>
        </div>
        <div class="stat">
          <div class="stat-number">12</div>
          <div class="stat-label">Horas de Formación</div>
        </div>
        <div class="stat">
          <div class="stat-number">85%</div>
          <div class="stat-label">Progreso Promedio</div>
        </div>
      </div>
      
      <div class="profile-content">
        <div class="profile-tabs">
          <div class="tab active" data-tab="info">Información Personal</div>
          <div class="tab" data-tab="courses">Mis Cursos</div>
          <div class="tab" data-tab="certificates">Certificados</div>
          <div class="tab" data-tab="settings">Configuración</div>
        </div>
        
        <div class="tab-content active" id="info">
          <div class="info-group">
            <h3>Datos Personales</h3>
            <div class="info-item">
              <div class="info-label">Nombre completo:</div>
              <div class="info-value">{{ Auth::user()->name }}</div>
            </div>
            <div class="info-item">
              <div class="info-label">Documento de identidad:</div>
              <div class="info-value">{{ Auth::user()->document_number }}</div>
            </div>
            <div class="info-item">
              <div class="info-label">Fecha de nacimiento:</div>
              <div class="info-value">{{ Auth::user()->updated_at }}</div>
            </div>
            <div class="info-item">
              <div class="info-label">Género:</div>
              <div class="info-value">Femenino</div>
            </div>
            <button class="edit-btn"><i class="fas fa-edit"></i> Editar información</button>
          </div>
          
          <div class="info-group">
            <h3>Información de Contacto</h3>
            <div class="info-item">
              <div class="info-label">Correo electrónico:</div>
              <div class="info-value">{{ Auth::user()->email }}</div>
            </div>
            <div class="info-item">
              <div class="info-label">Teléfono móvil:</div>
              <div class="info-value">+57 300 123 4567</div>
            </div>
            <div class="info-item">
              <div class="info-label">Dirección:</div>
              <div class="info-value">Calle 123 #45-67, Bogotá</div>
            </div>
            <button class="edit-btn"><i class="fas fa-edit"></i> Editar contacto</button>
          </div>
          
          <div class="info-group">
            <h3>Información Laboral</h3>
            <div class="info-item">
              <div class="info-label">Subred:</div>
              <div class="info-value">{{ Auth::user()->subred }}</div>
            </div>
            <div class="info-item">
              <div class="info-label">Cargo:</div>
              <div class="info-value">Especialista en Bienestar</div>
            </div>
            <div class="info-item">
              <div class="info-label">Fecha de ingreso:</div>
              <div class="info-value">{{ Auth::user()->updated_at }}</div>
            </div>
          </div>
        </div>
        
        <div class="tab-content" id="courses">
          <h3>Mis Cursos</h3>
          <p>Gestiona tu progreso en los cursos disponibles</p>
          
          <div class="courses-grid">
            <div class="course-card">
              <div class="course-img">
                <i class="fas fa-book-open"></i>
              </div>
              <div class="course-content">
                <div class="course-title">Inducción Septiembre 2025</div>
                <p>Curso de introducción al programa de bienestar</p>
                <div class="course-progress">
                  <div class="progress-bar">
                    <div class="progress-fill" style="width: 90%"></div>
                  </div>
                  <div class="progress-text">
                    <span>Progreso</span>
                    <span>90%</span>
                  </div>
                </div>
                <a href="#" class="course-btn">Continuar curso</a>
              </div>
            </div>
            
            <div class="course-card">
              <div class="course-img">
                <i class="fas fa-heart"></i>
              </div>
              <div class="course-content">
                <div class="course-title">ICS 1</div>
                <p>Introducción al cuidado de la salud</p>
                <div class="course-progress">
                  <div class="progress-bar">
                    <div class="progress-fill" style="width: 100%"></div>
                  </div>
                  <div class="progress-text">
                    <span>Progreso</span>
                    <span>100%</span>
                  </div>
                </div>
                <a href="#" class="course-btn">Ver certificado</a>
              </div>
            </div>
            
            <div class="course-card">
              <div class="course-img">
                <i class="fas fa-hand-holding-heart"></i>
              </div>
              <div class="course-content">
                <div class="course-title">GCS Julio 2025</div>
                <p>Gestión del cuidado de la salud</p>
                <div class="course-progress">
                  <div class="progress-bar">
                    <div class="progress-fill" style="width: 65%"></div>
                  </div>
                  <div class="progress-text">
                    <span>Progreso</span>
                    <span>65%</span>
                  </div>
                </div>
                <a href="#" class="course-btn">Continuar curso</a>
              </div>
            </div>
            
            <div class="course-card">
              <div class="course-img">
                <i class="fas fa-seedling"></i>
              </div>
              <div class="course-content">
                <div class="course-title">GoMPI 2025</div>
                <p>Gestión de mindfulness e inteligencia emocional</p>
                <div class="course-progress">
                  <div class="progress-bar">
                    <div class="progress-fill" style="width: 100%"></div>
                  </div>
                  <div class="progress-text">
                    <span>Progreso</span>
                    <span>100%</span>
                  </div>
                </div>
                <a href="#" class="course-btn">Ver certificado</a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="tab-content" id="certificates">
          <h3>Mis Certificados</h3>
          <p>Aquí puedes gestionar y descargar tus certificados obtenidos</p>
          <!-- Contenido de certificados -->
        </div>
        
        <div class="tab-content" id="settings">
          <h3>Configuración de Cuenta</h3>
          <p>Personaliza tu experiencia en la plataforma</p>
          <!-- Contenido de configuración -->
        </div>
      </div>
    </main>
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

  <script>
    // Funcionalidad para las pestañas
    document.addEventListener('DOMContentLoaded', function() {
      const tabs = document.querySelectorAll('.tab');
      const tabContents = document.querySelectorAll('.tab-content');
      
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const tabId = tab.getAttribute('data-tab');
          
          // Remover clase active de todas las pestañas y contenidos
          tabs.forEach(t => t.classList.remove('active'));
          tabContents.forEach(content => content.classList.remove('active'));
          
          // Agregar clase active a la pestaña y contenido seleccionado
          tab.classList.add('active');
          document.getElementById(tabId).classList.add('active');
        });
      });
    });
  </script>

</body>
</html>