@extends('layouts.admin.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection

@section('content')

    <div class="container">
        <!-- Estadísticas rápidas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">{{ DB::table('users')->where('subred', Auth::user()->subred)->count() }}
                        </div>
                        <div class="stat-label">Usuarios Registrados</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Cursos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="stat-number">892</div>
                        <div class="stat-label">Certificados Emitidos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">78%</div>
                        <div class="stat-label">Tasa de Finalización</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Columna izquierda -->
            <div class="col-md-8">
                <!-- Gestión de usuarios -->
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Gestión de Usuarios</h4>
                        <div class="search-box">
                            <form method="GET" action="{{ route('usuarios.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar usuario..."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listaUsuarios as $usuario)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2">
                                                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                                </div>
                                                <div>{{ $usuario->name }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->profile->name ?? 'Sin perfil'}}</td>
                                        <td>
                                            @if($usuario->is_active)
                                                <span class="status-badge status-active">Activo</span>
                                                <form action="{{ route('usuarios.toggle', $usuario->id) }}" method="POST"
                                                    style="display:inline; margin-left: 12px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-warning">Desactivar</button>
                                                </form>
                                            @else
                                                <span class="status-badge status-inactive">Inactivo</span>
                                                <form action="{{ route('usuarios.toggle', $usuario->id) }}" method="POST"
                                                    style="display:inline; margin-left: 12px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success">Activar</button>
                                                </form>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Mostrando {{ $listaUsuarios->firstItem() }} - {{ $listaUsuarios->lastItem() }}
                            de {{ $listaUsuarios->total() }} usuarios
                        </div>
                        <div>
                            {{ $listaUsuarios->links() }}
                        </div>
                    </div>

                </div>

                <!-- Gestión de cursos -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-book me-2"></i>Gestión de Cursos
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($modulos as $curso)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $curso->title }}</h5>
                                            <p class="card-text">{{ $curso->description }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-primary">{{ $curso->inscritos }} inscritos</span>
                                                <button class="btn btn-outline-primary btn-sm">Gestionar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $modulos->links() }}
                        </div>


                        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarCurso">
                            <i class="fas fa-plus"></i> Agregar Curso
                        </button>


                    </div>



                </div>





            </div>

            <!-- Columna derecha -->
            <div class="col-md-4">
                <!-- Acciones rápidas -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">

                            <button class="btn btn-outline-primary text-start">
                                <i class="fas fa-chart-bar me-2"></i>Ver Reportes
                            </button>
                            <button class="btn btn-outline-primary text-start">
                                <i class="fas fa-cog me-2"></i>Configuración del Sistema
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actividad reciente -->
                <div class="card mt-4">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i>Actividad Reciente
                    </div>
                    <div class="card-body">
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-check text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Nuevo usuario registrado</h6>
                                    <p class="small text-muted mb-0">Laura Martínez se unió al curso de Bienestar
                                        Familiar</p>
                                    <span class="small text-muted">Hace 15 minutos</span>
                                </div>
                            </div>
                        </div>
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-certificate text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Certificado emitido</h6>
                                    <p class="small text-muted mb-0">Carlos Ruiz completó el curso de Salud Mental</p>
                                    <span class="small text-muted">Hace 2 horas</span>
                                </div>
                            </div>
                        </div>
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-book text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Nuevo contenido agregado</h6>
                                    <p class="small text-muted mb-0">Se añadió módulo 5 al curso de Nutrición Saludable
                                    </p>
                                    <span class="small text-muted">Ayer a las 14:30</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container text-center">
            <h4>MAS Bienestar en tu hogar</h4>
            <p class="mb-3">Bienestar integral para tu familia</p>
            <div class="section-divider mx-auto" style="width: 50%;"></div>
            <p class="mb-0">&copy; 2023 MAS Bienestar. Todos los derechos reservados.</p>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarCurso" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('modulos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Título</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Descripción</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Duración (minutos)</label>
                            <input type="number" name="duration" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Link Genially 1</label>
                            <input type="text" name="genilay_recursos_link1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Link Genially 2</label>
                            <input type="text" name="genilay_recursos_link2" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Recursos (PDF/Word)</label>
                            <input type="file" name="recursos[]" class="form-control" multiple>
                        </div>

                        <div id="steps-container">
                            <label>Pasos del Módulo</label>
                            <div class="step mb-3" data-index="0">
                                <input type="text" name="steps[0][text]" class="form-control mb-2"
                                    placeholder="Descripción del paso">
                                <input type="text" name="steps[0][icon]" class="form-control mb-2"
                                    placeholder="Ícono (ej: fa-user)">
                                <select name="steps[0][type]" class="form-control mb-2">
                                    <option value="">Sin archivo</option>
                                    <option value="image">Imagen</option>
                                    <option value="video">Video</option>
                                    <option value="text">Texto</option>
                                </select>
                                <input type="file" name="steps[0][file]" class="form-control mb-2">
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="addStep">+ Agregar Paso</button>


                        <div id="preguntas-container mt-5">
                            <label>Preguntas del Examen (Selección Múltiple)</label>
                            <div class="pregunta mb-3" data-index="0">
                                <input type="text" name="preguntas[0][pregunta]" class="form-control mb-2"
                                    placeholder="Pregunta">
                                <div class="opciones">
                                    <div class="d-flex mb-1">
                                        <input type="text" name="preguntas[0][opciones][]" class="form-control me-2"
                                            placeholder="Opción">
                                        <label><input type="checkbox" name="preguntas[0][respuestas_correctas][]" value="0">
                                            Correcta</label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary add-option">+
                                    Agregar Opción</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="addPregunta">+
                            Agregar Pregunta</button>

                        <script>
                            let preguntaIndex = 1;

                            document.getElementById('addPregunta').addEventListener('click', function () {
                                let container = document.getElementById('preguntas-container');
                                let div = document.createElement('div');
                                div.classList.add('pregunta', 'mb-3');
                                div.setAttribute('data-index', preguntaIndex);

                                div.innerHTML = `
                                                        <input type="text" name="preguntas[${preguntaIndex}][pregunta]" class="form-control mb-2" placeholder="Pregunta">
                                                        <div class="opciones">
                                                            <div class="d-flex mb-1">
                                                                <input type="text" name="preguntas[${preguntaIndex}][opciones][]" class="form-control me-2" placeholder="Opción">
                                                                <label><input type="checkbox" name="preguntas[${preguntaIndex}][respuestas_correctas][]" value="0"> Correcta</label>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary add-option">+ Agregar Opción</button>
                                                    `;

                                container.appendChild(div);
                                preguntaIndex++;
                            });

                            document.addEventListener('click', function (e) {
                                if (e.target && e.target.classList.contains('add-option')) {
                                    let preguntaDiv = e.target.closest('.pregunta');
                                    let index = preguntaDiv.getAttribute('data-index');
                                    let opcionesDiv = preguntaDiv.querySelector('.opciones');
                                    let optionIndex = opcionesDiv.querySelectorAll('.d-flex').length;

                                    let optionDiv = document.createElement('div');
                                    optionDiv.classList.add('d-flex', 'mb-1');
                                    optionDiv.innerHTML = `
                                                            <input type="text" name="preguntas[${index}][opciones][]" class="form-control me-2" placeholder="Opción">
                                                            <label><input type="checkbox" name="preguntas[${index}][respuestas_correctas][]" value="${optionIndex}"> Correcta</label>
                                                        `;
                                    opcionesDiv.appendChild(optionDiv);
                                }
                            });
                        </script>

                        <script>
                            let stepIndex = 1;

                            document.getElementById('addStep').addEventListener('click', function () {
                                let container = document.getElementById('steps-container');
                                let div = document.createElement('div');
                                div.classList.add('step', 'mb-3');
                                div.setAttribute('data-index', stepIndex);

                                div.innerHTML = `
            <input type="text" name="steps[${stepIndex}][text]" class="form-control mb-2" placeholder="Descripción del paso">
            <input type="text" name="steps[${stepIndex}][icon]" class="form-control mb-2" placeholder="Ícono (ej: fa-user)">
            <select name="steps[${stepIndex}][type]" class="form-control mb-2">
                <option value="">Sin archivo</option>
                <option value="image">Imagen</option>
                <option value="video">Video</option>
                <option value="text">Texto</option>
            </select>
            <input type="file" name="steps[${stepIndex}][file]" class="form-control mb-2">
        `;

                                container.appendChild(div);
                                stepIndex++;
                            });
                        </script>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad para los interruptores de activar/desactivar usuarios
        document.addEventListener('DOMContentLoaded', function () {
            const toggleSwitches = document.querySelectorAll('.toggle-switch input');

            toggleSwitches.forEach(switchEl => {
                switchEl.addEventListener('change', function () {
                    const statusBadge = this.closest('tr').querySelector('.status-badge');

                    if (this.checked) {
                        statusBadge.textContent = 'Activo';
                        statusBadge.className = 'status-badge status-active';
                    } else {
                        statusBadge.textContent = 'Inactivo';
                        statusBadge.className = 'status-badge status-inactive';
                    }
                });
            });
        });
    </script>

@endsection