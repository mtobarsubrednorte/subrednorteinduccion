@extends('layouts.app')
@section('title', 'Perfil de Usuario - MAS Bienestar')
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/perfil/perfil.css') }}">
@endsection

@section('content')

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
|
    <div class="profile-stats">
      <div class="stat">
        <div class="stat-number">4</div>
        <div class="stat-label">Modulos</div>
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

        <div class="certificates-grid">
          @foreach ($certificates as $certificate)
            <div class="certificate-card">
              <div class="certificate-preview">
                <iframe 
                  src="{{ asset('storage/'.$certificate->file_path) }}" 
                  title="Vista previa del certificado"
                  loading="lazy"
                ></iframe>
              </div>

              <div class="certificate-body">
                <h4 class="certificate-title">{{ $certificate->event }}</h4>
                <p class="certificate-date">Aprobado el {{ $certificate->created_at->format('d \d\e F, Y') }}</p>
                <div class="certificate-actions">
                  <a href="{{ asset('storage/'.$certificate->file_path) }}" class="certificate-btn" download>
                    Descargar PDF
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>


      <div class="tab-content" id="settings">
        <h3>Configuración de Cuenta</h3>
        <p>Personaliza tu experiencia en la plataforma</p>
        <!-- Contenido de configuración -->
      </div>
    </div>
  </main>
  </div>



  <script>
    // Funcionalidad para las pestañas
    document.addEventListener('DOMContentLoaded', function () {
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

@endsection