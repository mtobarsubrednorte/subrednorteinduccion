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
                <img src="https://www.zizurmayor.es/wp-content/uploads/2022/11/sin-perfil.jpg" alt="Avatar usuario">
            </div>
            <div class="profile-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p>Registrado desde: {{ Auth::user()->created_at->format('d \\d\\e F \\d\\e Y') }}</p>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat">
                <div class="stat-number">{{ count($modulos) }}</div>
                <div class="stat-label">Modulos</div>
            </div>
            <div class="stat">
                <div class="stat-number">{{ $aprobados->count() }}</div>
                <div class="stat-label">Modulos Completados</div>
            </div>
            <div class="stat">
                <div class="stat-number">{{ $horasFormacion }}</div>
                <div class="stat-label">Minutos de Formación</div>
            </div>
            <div class="stat">
                <div class="stat-number">{{ $progresoPromedio ?? 0 }}%</div>
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
                        <div class="info-label">Género:</div>
                        <div class="info-value">{{ Auth::user()->gender }}</div>
                    </div>
                    <button class="edit-btn"><i class="fas fa-edit"></i> Editar información</button>
                </div>

                <div class="info-group">
                    <h3>Información de Contacto</h3>
                    <div class="info-item">
                        <div class="info-label">Correo electrónico:</div>
                        <div class="info-value">{{ Auth::user()->email }}</div>
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
                        <div class="info-value">{{ Auth::user()->profile->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Fecha de ingreso:</div>
                        <div class="info-value">{{ Auth::user()->updated_at->format('d \\d\\e F \\d\\e Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="courses">
                <h3>Mis Cursos</h3>
                <p>Gestiona tu progreso en los cursos disponibles</p>

                <div class="courses-grid">

                    @foreach ($progresoPorModulo as $mol)
                        <div class="course-card">
                            <div class="course-img">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="course-content">
                                <div class="course-title">{{ $mol->title }}</div>
                                <p>{{ $mol->description }}</p>
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                            style="width: @if ($mol->progreso) {{ $mol->progreso }}% @else 75% @endif">
                                        </div>
                                    </div>
                                    <div class="progress-text">
                                        <span>Progreso</span>
                                        <span>
                                            @if ($mol->progreso)
                                                {{ $mol->progreso }}%
                                            @else
                                                75%
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @if ($mol->progreso >= 100)
                                    <div class="course-completed">Completado</div>
                                @else
                                    <a href="#" class="course-btn">Continuar curso</a>
                                @endif
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>

            <div class="tab-content" id="certificates">
                <h3>Mis Certificados</h3>
                <p>Aquí puedes gestionar y descargar tus certificados obtenidos</p>

                <div class="certificates-grid">
                    @foreach ($certificates as $certificate)
                        <div class="certificate-card">
                            <div class="certificate-preview">
                                <iframe src="{{ asset('storage/' . $certificate->file_path) }}"
                                    title="Vista previa del certificado" loading="lazy"></iframe>
                            </div>

                            <div class="certificate-body">
                                <h4 class="certificate-title">{{ $certificate->event }}</h4>
                                <p class="certificate-date">Aprobado el
                                    {{ $certificate->created_at->format('d \d\e F, Y') }}</p>
                                <div class="certificate-actions">
                                    <a href="{{ asset('storage/' . $certificate->file_path) }}" class="certificate-btn"
                                        download>
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

    <!-- Modal para editar información personal -->
    <div id="editPersonalModal" class="modal hidden">
        <div class="modal-content">
            <h3>Editar Información Personal</h3>
            <form action="{{ route('perfil.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre completo</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                </div>

                <div class="form-group">
                    <label>Documento de identidad</label>
                    <input type="text" name="document_number" value="{{ Auth::user()->document_number }}">
                </div>

                <div class="form-group">
                    <label>Género</label>
                    <select name="gender">
                        <option value="">Seleccione...</option>
                        <option value="Masculino" {{ Auth::user()->gender == 'Masculino' ? 'selected' : '' }}>Masculino
                        </option>
                        <option value="Femenino" {{ Auth::user()->gender == 'Femenino' ? 'selected' : '' }}>Femenino
                        </option>
                        <option value="Otro" {{ Auth::user()->gender == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="save-btn">Guardar</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('editPersonalModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar información de contacto -->
    <div id="editContactModal" class="modal hidden">
        <div class="modal-content">
            <h3>Editar Información de Contacto</h3>
            <form action="{{ route('perfil.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>
                <div class="form-group">
                    <label>Subred</label>
                    <input type="text" name="subred" value="{{ Auth::user()->subred }}">
                </div>
                <div class="form-actions">
                    <button type="submit" class="save-btn">Guardar</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('editContactModal')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>




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

        // Abrir los modales de edición
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.textContent.includes('información')) {
                    document.getElementById('editPersonalModal').classList.remove('hidden');
                } else if (this.textContent.includes('contacto')) {
                    document.getElementById('editContactModal').classList.remove('hidden');
                }
            });
        });

        // Cerrar modal
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

@endsection
