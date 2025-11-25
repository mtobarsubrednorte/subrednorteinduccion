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
                        <div class="stat-label">Us. Registrados {{ Auth::user()->subred }}</div>
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
                        <div class="stat-number">{{ DB::table('certificates')->count() }}</div>
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
                        @php
                            $totalUsuarios = DB::table('users')
                                ->where('subred', Auth::user()->subred)
                                ->count();

                            $totalCertificados = DB::table('certificates')
                                ->join('users', 'certificates.user_id', '=', 'users.id')
                                ->where('users.subred', Auth::user()->subred)
                                ->count();

                            $porcentaje = $totalUsuarios > 0 ? ($totalCertificados / $totalUsuarios) * 100 : 0;
                        @endphp
                        <div class="stat-number">{{ number_format($porcentaje, 1) }}%</div>
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
                        <h4 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Gestión de Usuarios
                            {{ Auth::user()->subred }}</h4>


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
                                                    <button type="submit" class="btn btn-sm btn-warning"><i
                                                            class="fa-solid fa-xmark"></i></button>
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

                    <div class="d-flex justify-content-between align-items-center mt-3 px-2">


                        <div>
                            {{ $listaUsuarios->links() }}
                        </div>
                    </div>

                </div>

                <!-- Gestión de cursos -->
                <div class="cursos-panel">
                    <div class="cursos-panel-header">
                        <i class="fas fa-book me-2"></i>Gestión de Cursos
                    </div>
                    <div class="cursos-panel-body">
                        <div class="modulos-grid-container row">
                            @foreach ($modulos as $curso)
                                <div class="modulo-item-wrapper col-md-6">
                                    <div class="modulo-card">
                                        <div class="modulo-content-wrapper">
                                            <h5 class="modulo-title">{{ $curso->title }}</h5>
                                            <p class="modulo-description">{{ $curso->description }}</p>
                                            <div
                                                class="modulo-actions-container d-flex justify-content-between align-items-center">
                                                <button class="btn-modulo-edit btn-editar-curso"
                                                    data-info='@json($curso)'>
                                                    Editar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <div class="pagination-modulos">
                                {{ $modulos->links() }}
                            </div>
                        </div>

                        <button class="btn-add-modulo btn mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarCurso">
                            <i class="fas fa-plus"></i> Agregar Curso
                        </button>
                    </div>
                </div>

            </div>

            <!-- Columna derecha -->
            <div class="col-md-4">
                <!-- Acciones rápidas -->


                <!-- Actividad reciente -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i>Actividad Reciente
                    </div>
                    <div class="card-body" id="activity-container">
                        <p class="text-muted">Cargando actividades...</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-file"></i> Descargar Reporte</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('exportar.usuarios') }}" method="GET" class="align-items-center">
                            <select name="subred" class="form-select me-2" required>
                                <option value="">Selecciona una Subred</option>
                                <option value="Norte">Norte</option>
                                <option value="Sur">Sur</option>
                                <option value="Sur Occidente">Sur Occidente</option>
                                <option value="Centro Oriente">Centro Oriente</option>
                            </select>
                            <button class="btn btn-success mt-2"><i class="fa-solid fa-file-excel"></i> Descargar
                                Excel</button>
                        </form>

                    </div>

                </div>

                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-certificate"></i> Verificar certificado</h3>
                    </div>
                    <div class="card-body">
                        <label for="doc">Número de documento</label>
                        <input class="form-control mb-2" type="text" id="doc" name="doc"
                            placeholder="Ej: 12345678">
                        <button class="btn btn-info text-white" id="btnVerificar">Verificar ahora</button>
                    </div>
                </div>

                <!-- Modal de resultado -->
                <div class="modal fade" id="modalResultado" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Resultado de verificación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="resultadoContenido">
                                <!-- Se llenará dinámicamente -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
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
                            <label><strong>Estado del Curso</strong></label><br>
                            <label class="switch">
                                <input type="checkbox" name="is_active" checked>
                                <span class="slider round"></span>
                            </label>
                            <span id="isactive" class="ms-2">Activo</span>
                        </div>

                        <div class="mb-3">
                            <label><strong>Usuarios que podrán ver este curso</strong></label>
                            <select name="visible_users[]" class="form-control" multiple style="height: 200px;">
                                @foreach ($listaUsuarios as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Mantén presionado CTRL para seleccionar varios.</small>
                        </div>

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
                                Agregar Pregunta
                            </button>

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
            console.log(info.active);
            const modal = new bootstrap.Modal(document.getElementById('modalAgregarCurso'));
            modal.show();

            const active = info.active === 1 ? true : false;
            const selectedUsers = JSON.parse(info.active_users ?? "[]");
            console.log(active)

            // Campos básicos
            document.getElementById('id_modulo').value = info.id || '';
            document.getElementById('titulo_modal').textContent = 'Editar Módulo';
            document.querySelector('[name="title"]').value = info.title || '';
            document.querySelector('[name="description"]').value = info.description || '';
            document.querySelector('[name="duration"]').value = info.duration || '';
            document.querySelector('[name="genilay_recursos_link1"]').value = info.genilay_recursos_link1 || '';
            document.querySelector('[name="genilay_recursos_link2"]').value = info.genilay_recursos_link2 || '';

            document.querySelector("input[name='is_active']").checked = active;

            if(active){
                document.getElementById('isactive').textContent = 'Activo';
            } else {
                document.getElementById('isactive').textContent = 'Inactivo';
            }

            const select = document.querySelector("select[name='visible_users[]']");
            [...select.options].forEach(option => {
                option.selected = selectedUsers.includes(parseInt(option.value));
            });

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
                    const iconClass = extension === 'pdf' ?
                        'fa-file-pdf text-danger' :
                        (extension === 'doc' || extension === 'docx') ?
                        'fa-file-word text-primary' :
                        'fa-file text-secondary';

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
                    ${step.type == 'image' 
                        ? `<img src="/storage/${step.file}" class="img-thumbnail mb-2" style="max-width:120px;">`
                        : ''
                        }

                        ${step.type == 'video' 
                        ? `<video src="/storage/${step.file}" class="img-thumbnail mb-2" style="max-width:160px; height:auto;" controls></video>`
                        : ''
                        }


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
                    <input type="file" name="imagenes[${index}][file]" class="form-control mb-2" accept="image/*" >


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

                    // normalizamos respuestas_correctas a strings para comparar sin problemas
                    const corrects = (p.respuestas_correctas || []).map(x => String(x));

                    const opcionesHTML = (p.opciones || []).map((op, i) => {
                        const checked = corrects.includes(String(i)) ? 'checked' : '';
                        return `
                    <div class="d-flex mb-1 align-items-center">
                        <input type="text" name="preguntas[${index}][opciones][]" class="form-control me-2" value="${op}">
                        <label class="mb-0">
                            <input type="checkbox" name="preguntas[${index}][respuestas_correctas][]" value="${i}" ${checked}>
                            Correcta
                        </label>
                    </div>`;
                    }).join('');

                    // incluir id oculto para identificar la pregunta en el backend (si existe)
                    const preguntaIdHidden = p.id ?
                        `<input type="hidden" name="preguntas[${index}][id]" value="${p.id}">` : '';

                    const preguntaHTML = `
                <div class="pregunta mb-3 p-2 border rounded position-relative" data-index="${index}">
                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 btn-remove-pregunta" data-id="${p.id}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    ${preguntaIdHidden}
                    <input type="text" name="preguntas[${index}][pregunta]" class="form-control mb-2" value="${p.pregunta}">
                    <div class="opciones">${opcionesHTML}</div>
                </div>`;
                    preguntasContainer.insertAdjacentHTML('beforeend', preguntaHTML);
                });

                // 🔥 Evento eliminar pregunta (igual que antes)
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

        document.getElementById('modalAgregarCurso').addEventListener('hidden.bs.modal', function() {
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

    <script>
        document.getElementById('btnVerificar').addEventListener('click', function() {
            const doc = document.getElementById('doc').value.trim();

            if (!doc) {
                alert('Por favor ingresa un número de documento.');
                return;
            }

            fetch("{{ route('certificate.verify') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        doc
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const contenido = document.getElementById('resultadoContenido');
                    if (data.success) {
                        contenido.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h5>${data.message}</h5>
                            <p><strong>Nombre:</strong> ${data.user}</p>
                            <p><strong>Documento:</strong> ${data.document}</p>
                            <p><strong>Codigo Certificado:</strong> ${data.certificado.verification_code }</p>
                            <p><strong>Emitido el:</strong> ${data.certificado.created_at}</p>
                        </div>
                    `;
                    } else {
                        contenido.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                            <h5>${data.message}</h5>
                        </div>
                    `;
                    }

                    // Mostrar el modal
                    const modal = new bootstrap.Modal(document.getElementById('modalResultado'));
                    modal.show();
                })
                .catch(err => console.error(err));
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('activity-container');

            async function loadActivities() {
                try {
                    const response = await fetch("{{ route('activities.recent') }}");
                    const activities = await response.json();

                    if (activities.length === 0) {
                        container.innerHTML = `<p class="text-muted">No hay actividad reciente.</p>`;
                        return;
                    }

                    console.log(activities)

                    container.innerHTML = activities.map(activity => {
                        let icon = '';
                        switch (activity.type) {
                            case 'usuario':
                                icon = '<i class="fas fa-user-check text-success"></i>';
                                break;
                            case 'certificado':
                                icon = '<i class="fas fa-certificate text-primary"></i>';
                                break;
                            case 'modulo':
                                icon = '<i class="fas fa-book text-info"></i>';
                                break;
                            default:
                                icon = '<i class="fas fa-info-circle text-secondary"></i>';
                        }

                        const created = new Date(activity.created_at);
                        const diff = timeSince(created);

                        return `
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">${icon}</div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">${activity.title}</h6>
                                    <p class="small text-muted mb-0">${activity.description}</p>
                                    <span class="small text-muted">${diff}</span>
                                </div>
                            </div>
                        </div>`;
                    }).join('');
                } catch (error) {
                    console.error('Error al cargar actividades:', error);
                }
            }

            // Función para mostrar el tiempo relativo
            function timeSince(date) {
                const seconds = Math.floor((new Date() - date) / 1000);
                const intervals = {
                    año: 31536000,
                    mes: 2592000,
                    día: 86400,
                    hora: 3600,
                    minuto: 60,
                };
                for (const [key, value] of Object.entries(intervals)) {
                    const interval = Math.floor(seconds / value);
                    if (interval >= 1)
                        return `hace ${interval} ${key}${interval > 1 ? 's' : ''}`;
                }
                return "justo ahora";
            }

            loadActivities();
            setInterval(loadActivities, 10000); // Actualiza cada 10 segundos
        });
    </script>
@endsection
