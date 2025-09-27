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