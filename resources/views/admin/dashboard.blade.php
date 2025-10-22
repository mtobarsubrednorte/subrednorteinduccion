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
                        <div class="stat-number">{{ DB::table('modulos')->count() }}</div>
                        <div class="stat-label">Modulos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="stat-number">0</div>
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
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Buscar usuario..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (session('success'))
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
                                        <td>{{ $usuario->profile->name ?? 'Sin perfil' }}</td>
                                        <td>
                                            @if ($usuario->is_active)
                                                <span class="status-badge status-active">Activo</span>
                                                <form action="{{ route('usuarios.toggle', $usuario->id) }}" method="POST"
                                                    style="display:inline; margin-left: 12px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-warning">Desactivar</button>
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
                            @foreach ($modulos as $curso)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $curso->title }}</h5>
                                            <p class="card-text">{{ $curso->description }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button 
                                                    class="btn btn-warning btn-editar-curso"
                                                    data-info='@json($curso)'
                                                >
                                                    Editar
                                                </button>



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

                <div class="card mt-4">
                    <div class="card-header">
                        <h3><i class="fas fa-certificate"></i> Verificar certificado</h3>
                    </div>
                    <div class="card-body">
                        <label for="doc">Número de documento</label>
                        <input type="text" id="doc" name="doc" placeholder="Ej: 12345678">
                        <button>Verificar ahora</button>
                    </div>

                </div>

                <div>
                    <form action="#" type="POST">
                        <label for="perfil">Perfil</label>
                        <select name="perfiles" id="">
                            @foreach ($perfiles as $perfil)
                                <option value="{{ $perfil->id }}">{{ $perfil->name }}</option>
                            @endforeach
                        </select>

                        <label for="description">Description</label>
                        <input type="text" class="form-contol">

                        <button>Guardar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarCurso" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('modulos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <input type="hidden" name="id" id="id_modulo">


                    <div class="modal-header">
                        <h5 id="titulo_modal" class="modal-title">Agregar Modulo</h5>
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
                            <input type="number" name="duration" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Link Genially 1</label>
                                <input type="text" name="genilay_recursos_link1" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Link Genially 2</label>
                                <input type="text" name="genilay_recursos_link2" class="form-control">
                            </div>

                        </div>

                        <div class="mb-3">
                            <div class="title-modal-seccion">
                                <label>Recursos (actuales)</label>
                            </div>
                            <div id="recursos-container" class="d-flex flex-wrap gap-3"></div>
                        </div>


                        <div class="mb-3">
                            <div class="title-modal-seccion">
                                <label>Recursos (PDF/Word)</label>
                            </div>
                            <input type="file" name="recursos[]" class="form-control" multiple>
                        </div>

                        <div class="modulos-modal-seccion">

                            <div class="title-modal-seccion">
                                <label>Pasos del Módulo</label>
                            </div>

                            <div id="steps-container">
                                
                                <div class="step mb-3" data-index="0">
                                    <input type="text" name="steps[0][text]" class="form-control mb-2"
                                        placeholder="Descripción del paso">

                                    <!-- Selector de íconos -->
                                    <select name="steps[0][icon]" class="form-control mb-2 icon-select">
                                        <option value="">Selecciona un ícono</option>
                                        <option value="fa-right-to-bracket" data-icon="fa-right-to-bracket">
                                            🔑 Ingreso
                                        </option>
                                        <option value="fa-building" data-icon="fa-building">
                                            🏢 Predio
                                        </option>
                                        <option value="fa-magnifying-glass" data-icon="fa-magnifying-glass">
                                            🔍 Buscar
                                        </option>
                                        <option value="fa-house" data-icon="fa-house">
                                            🏠 Casa
                                        </option>
                                        <option value="fa-user-plus" data-icon="fa-user-plus">
                                            👤➕ Usuario
                                        </option>
                                        <option value="fa-people-roof" data-icon="fa-people-roof">
                                            👨‍👩‍👧 Familia
                                        </option>
                                        <option value="fa-notes-medical" data-icon="fa-notes-medical">
                                            📝 Salud
                                        </option>
                                        <option value="fa-handshake" data-icon="fa-handshake">
                                            🤝 Acuerdo
                                        </option>
                                        <option value="fa-clipboard-list" data-icon="fa-clipboard-list">
                                            📋 Lista
                                        </option>
                                        <option value="fa-id-card" data-icon="fa-id-card">
                                            🪪 Documento
                                        </option>
                                    </select>


                                    <select name="steps[0][type]" class="form-control mb-2">
                                        <option value="">Sin archivo</option>
                                        <option value="image">Imagen</option>
                                        <option value="video">Video</option>
                                        <option value="text">Texto</option>
                                    </select>
                                    <input type="file" name="steps[0][file]" class="form-control mb-2">
                                </div>


                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm" id="addStep">+ Agregar
                                Paso</button>

                        </div>



                        <div class="modulos-modal-seccion">
                            <div class="title-modal-seccion">
                                <label>Imágenes del Módulo</label>
                            </div>
                            <div id="imagenes-container">

                                <div class="imagen mb-3" data-index="0">
                                    <input type="file" name="imagenes[0][file]" class="form-control mb-2">
                                    <input type="text" name="imagenes[0][description]" class="form-control mb-2"
                                        placeholder="Descripción de la imagen">
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addImagen">+ Agregar
                                Imagen</button>
                        </div>

                        <div class="modulos-modal-seccion">

                            <div class="title-modal-seccion">
                                <label>Preguntas del Examen (Selección Múltiple)</label>
                            </div>
                            <div id="preguntas-container">
                                <div class="pregunta mb-3" data-index="0">
                                    <input type="text" name="preguntas[0][pregunta]" class="form-control mb-2"
                                        placeholder="Pregunta">
                                    <div class="opciones">
                                        <div class="d-flex mb-1">
                                            <input type="text" name="preguntas[0][opciones][]"
                                                class="form-control me-2" placeholder="Opción">
                                            <label><input type="checkbox" name="preguntas[0][respuestas_correctas][]"
                                                    value="0">
                                                Correcta</label>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-option">+
                                        Agregar Opción</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addPregunta">+
                                Agregar Pregunta</button>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
        document.querySelectorAll('.btn-editar-curso').forEach(btn => {
            btn.addEventListener('click', e => {
                const info = JSON.parse(btn.getAttribute('data-info'));
                abrirModalEditar(info);
            });
        });


        function abrirModalEditar(info) {
    console.log(info);
    const modal = new bootstrap.Modal(document.getElementById('modalAgregarCurso'));
    modal.show();

    // Campos básicos
    document.getElementById('id_modulo').value = info.id || '';
    document.getElementById('titulo_modal').textContent = 'Editar Módulo';
    document.querySelector('[name="title"]').value = info.title || '';
    document.querySelector('[name="description"]').value = info.description || '';
    document.querySelector('[name="duration"]').value = info.duration || '';
    document.querySelector('[name="genilay_recursos_link1"]').value = info.genilay_recursos_link1 || '';
    document.querySelector('[name="genilay_recursos_link2"]').value = info.genilay_recursos_link2 || '';

    // Limpiar contenedores dinámicos
    const stepsContainer = document.getElementById('steps-container');
    const imgContainer = document.getElementById('imagenes-container');
    const preguntasContainer = document.getElementById('preguntas-container');
    const recursosContainer = document.getElementById('recursos-container');

    stepsContainer.innerHTML = '';
    imgContainer.innerHTML = '';
    preguntasContainer.innerHTML = '';
    recursosContainer.innerHTML = '';

    // =====================
    // 🧩 Recursos actuales
    // =====================
    if (info.recursos && info.recursos.length) {
        info.recursos.forEach((recurso) => {
            const extension = recurso.original_name.split('.').pop().toLowerCase();
            const iconClass = extension === 'pdf'
                ? 'fa-file-pdf text-danger'
                : (extension === 'doc' || extension === 'docx')
                    ? 'fa-file-word text-primary'
                    : 'fa-file text-secondary';

            const recursoHTML = `
                <div class="card shadow-sm recurso-card position-relative" style="width: 150px; border-radius: 10px;">
                    <div class="card-body text-center p-2">
                        <i class="fa-solid ${iconClass}" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-1 small fw-semibold text-truncate" title="${recurso.original_name}">
                            ${recurso.original_name}
                        </p>
                        <a href="/storage/${recurso.file_path}" target="_blank" class="btn btn-sm btn-outline-primary w-100 mb-1">
                            Ver
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-recurso" data-id="${recurso.id}">
                            <i class="fa-solid fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            `;
            recursosContainer.insertAdjacentHTML('beforeend', recursoHTML);
        });

        // 🔥 Evento eliminar recurso
        recursosContainer.querySelectorAll('.btn-remove-recurso').forEach(btn => {
            btn.addEventListener('click', () => {
                const recursoId = btn.getAttribute('data-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_recursos[]';
                input.value = recursoId;
                recursosContainer.appendChild(input);
                btn.closest('.recurso-card').remove();
            });
        });
    }

    // =====================
    // 1️⃣ Pasos
    // =====================
    if (info.steps && info.steps.length) {
        info.steps.forEach((step, index) => {
            const stepHTML = `
                <div class="step mb-3 p-2 border rounded position-relative" data-index="${index}">
                    <input type="hidden" name="steps[${index}][id]" value="${step.id}">

                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 btn-remove-step" data-id="${step.id}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <input type="text" name="steps[${index}][text]" class="form-control mb-2" value="${step.text || ''}">
                    <select name="steps[${index}][icon]" class="form-control mb-2">
                        <option value="${step.icon}">${step.icon || 'Selecciona un ícono'}</option>
                    </select>
                    <select name="steps[${index}][type]" class="form-control mb-2">
                        <option value="${step.type || ''}">${step.type || 'Sin archivo'}</option>
                    </select>
                    ${img.image_path ? `<img src="/storage/${img.image_path}" class="img-thumbnail mb-2" style="max-width:120px;">` : ''}
                </div>`;
            stepsContainer.insertAdjacentHTML('beforeend', stepHTML);
        });

        // 🔥 Evento eliminar paso
        stepsContainer.querySelectorAll('.btn-remove-step').forEach(btn => {
            btn.addEventListener('click', () => {
                const stepId = btn.getAttribute('data-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_steps[]';
                input.value = stepId;
                stepsContainer.appendChild(input);
                btn.closest('.step').remove();
            });
        });
    }

    // =====================
    // 2️⃣ Imágenes
    // =====================
    if (info.images && info.images.length) {
        info.images.forEach((img, index) => {
            const imgHTML = `
                <div class="imagen mb-3 p-2 border rounded position-relative" data-index="${index}">
                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 btn-remove-img" data-id="${img.id}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <input type="hidden" name="imagenes[${index}][id]" value="${img.id}">
                    <input type="text" name="imagenes[${index}][description]" class="form-control mb-2" value="${img.description || ''}">
                    ${img.image_path ? `<img src="/storage/${img.image_path}" class="img-thumbnail mb-2" style="max-width:120px;">` : ''}
                    <input type="file" name="imagenes[${index}][file]" class="form-control mb-2" accept="image/*" hidden>


                </div>`;
            imgContainer.insertAdjacentHTML('beforeend', imgHTML);
        });

        // 🔥 Evento eliminar imagen
        imgContainer.querySelectorAll('.btn-remove-img').forEach(btn => {
            btn.addEventListener('click', () => {
                const imgId = btn.getAttribute('data-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_imagenes[]';
                input.value = imgId;
                imgContainer.appendChild(input);
                btn.closest('.imagen').remove();
            });
        });
    }

    // =====================
    // 3️⃣ Preguntas
    // =====================
    if (info.preguntas && info.preguntas.length) {
        info.preguntas.forEach((p, index) => {
            const opcionesHTML = p.opciones.map((op, i) => `
                <div class="d-flex mb-1">
                    <input type="text" name="preguntas[${index}][opciones][]" class="form-control me-2" value="${op}">
                    <label><input type="checkbox" name="preguntas[${index}][respuestas_correctas][]" value="${i}" ${p.respuestas_correctas.includes(i) ? 'checked' : ''}> Correcta</label>
                </div>`).join('');

            const preguntaHTML = `
                <div class="pregunta mb-3 p-2 border rounded position-relative" data-index="${index}">
                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 btn-remove-pregunta" data-id="${p.id}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <input type="text" name="preguntas[${index}][pregunta]" class="form-control mb-2" value="${p.pregunta}">
                    <div class="opciones">${opcionesHTML}</div>
                </div>`;
            preguntasContainer.insertAdjacentHTML('beforeend', preguntaHTML);
        });

        // 🔥 Evento eliminar pregunta
        preguntasContainer.querySelectorAll('.btn-remove-pregunta').forEach(btn => {
            btn.addEventListener('click', () => {
                const preguntaId = btn.getAttribute('data-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_preguntas[]';
                input.value = preguntaId;
                preguntasContainer.appendChild(input);
                btn.closest('.pregunta').remove();
            });
        });
    }
}

    document.getElementById('modalAgregarCurso').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
        document.getElementById('steps-container').innerHTML = '';
        document.getElementById('imagenes-container').innerHTML = '';
        document.getElementById('preguntas-container').innerHTML = '';
        document.getElementById('recursos-container').innerHTML = '';
    });


    </script>



    <script>
        let stepIndex = 1;

        document.getElementById('addStep').addEventListener('click', function() {
            let container = document.getElementById('steps-container');
            let div = document.createElement('div');
            div.classList.add('step', 'mb-3');
            div.setAttribute('data-index', stepIndex);

            div.innerHTML = `
                                    <input type="text" name="steps[${stepIndex}][text]" class="form-control mb-2" placeholder="Descripción del paso">

                                    <select name="steps[${stepIndex}][icon]" class="form-control mb-2 icon-select">
                                                    <option value="">Selecciona un ícono</option>
                                                    <option value="fa-right-to-bracket" data-icon="fa-right-to-bracket">
                                                        🔑 Ingreso
                                                    </option>
                                                    <option value="fa-building" data-icon="fa-building">
                                                        🏢 Predio
                                                    </option>
                                                    <option value="fa-magnifying-glass" data-icon="fa-magnifying-glass">
                                                        🔍 Buscar
                                                    </option>
                                                    <option value="fa-house" data-icon="fa-house">
                                                        🏠 Casa
                                                    </option>
                                                    <option value="fa-user-plus" data-icon="fa-user-plus">
                                                        👤➕ Usuario
                                                    </option>
                                                    <option value="fa-people-roof" data-icon="fa-people-roof">
                                                        👨‍👩‍👧 Familia
                                                    </option>
                                                    <option value="fa-notes-medical" data-icon="fa-notes-medical">
                                                        📝 Salud
                                                    </option>
                                                    <option value="fa-handshake" data-icon="fa-handshake">
                                                        🤝 Acuerdo
                                                    </option>
                                                    <option value="fa-clipboard-list" data-icon="fa-clipboard-list">
                                                        📋 Lista
                                                    </option>
                                                    <option value="fa-id-card" data-icon="fa-id-card">
                                                        🪪 Documento
                                                    </option>
                                                </select>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad para los interruptores de activar/desactivar usuarios
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitches = document.querySelectorAll('.toggle-switch input');

            toggleSwitches.forEach(switchEl => {
                switchEl.addEventListener('change', function() {
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

    <script>
        let imagenIndex = 1;

        document.getElementById('addImagen').addEventListener('click', function() {
            let container = document.getElementById('imagenes-container');
            let div = document.createElement('div');
            div.classList.add('imagen', 'mb-3');
            div.setAttribute('data-index', imagenIndex);

            div.innerHTML = `
                                        <input type="file" name="imagenes[${imagenIndex}][file]" class="form-control mb-2">
                                        <input type="text" name="imagenes[${imagenIndex}][description]" class="form-control mb-2" placeholder="Descripción de la imagen">
                                    `;
            container.appendChild(div);
            imagenIndex++;
        });
    </script>

    <script>
        let preguntaIndex = 1;

        document.getElementById('addPregunta').addEventListener('click', function() {
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

        document.addEventListener('click', function(e) {
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
@endsection
