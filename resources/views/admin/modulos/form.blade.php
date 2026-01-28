@extends('layouts.admin.admin')






@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    <style>
        /* Diseño Moderno: Tabs & Cards */
        .nav-pills .nav-link {
            color: #64748b;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .nav-pills .nav-link.active {
            background-color: #0d6efd !important;
            color: #0d6efd !important;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #e2e8f0;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .nav-link.active .step-number {
            background: #0d6efd;
            color: white;
        }

        .form-section-card {
            background: #ffffff;
            border: 1px solid #eef2f6;
            border-radius: 16px;
            padding: 30px;
        }

        .input-group-modern {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 5px 12px;
            transition: border-color 0.2s;
        }

        .input-group-modern:focus-within {
            border-color: #3b82f6;
            background: #fff;
        }

        .input-group-modern input,
        .input-group-modern textarea {
            border: none;
            background: transparent;
            box-shadow: none !important;
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            box-shadow: 0 4px 14px 0 rgba(13, 110, 253, 0.39);
        }

        .floating-add-btn {
            border: 2px dashed #cbd5e1;
            background: #f8fafc;
            color: #64748b;
            border-radius: 12px;
            padding: 15px;
            transition: all 0.3s;
        }

        .floating-add-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            background: #eff6ff;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#">Cursos</a></li>
                                <li class="breadcrumb-item active">Editor de Módulos</li>
                            </ol>
                        </nav>
                        <h3 class="fw-bold mb-0 text-dark">
                            {{ isset($modulo) ? 'Editar: ' . $modulo->title : 'Crear Módulo Educativo' }}
                        </h3>
                    </div>
                    <button type="submit" form="mainForm" class="btn btn-modern-primary text-white">
                        <i class="fas fa-save me-2"></i> Finalizar y Guardar
                    </button>
                </div>

                <form action="{{route('modulos.store') }}" method="POST" id="mainForm" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $modulo->id ?? '' }}">

                    <ul class="nav nav-pills mb-4 bg-light p-2 rounded-3 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-general" data-bs-toggle="pill"
                                data-bs-target="#content-general" type="button">
                                <span class="step-number">1</span> Info. General
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-pasos" data-bs-toggle="pill" data-bs-target="#content-pasos"
                                type="button">
                                <span class="step-number">2</span> Pasos del Curso
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-recursos" data-bs-toggle="pill"
                                data-bs-target="#content-recursos" type="button">
                                <span class="step-number">3</span> Multimedia
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-examen" data-bs-toggle="pill" data-bs-target="#content-examen"
                                type="button">
                                <span class="step-number">4</span> Evaluación
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="content-general">
                            <div class="form-section-card shadow-sm">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Título del Curso</label>
                                        <div class="input-group-modern">
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Nombre descriptivo del módulo"
                                                value="{{ $modulo->title ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">Descripción Corta</label>
                                        <div class="input-group-modern">
                                            <textarea name="description" class="form-control" rows="2"
                                                placeholder="¿Qué aprenderá el usuario?">{{ $modulo->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Duración</label>
                                        <div class="input-group-modern d-flex align-items-center">
                                            <i class="far fa-clock me-2 text-muted"></i>
                                            <input type="number" name="duration" class="form-control" placeholder="Minutos"
                                                value="{{ $modulo->duration ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Visibilidad Perfiles</label>
                                        <select name="visible_users[]" class="form-control select2" multiple>
                                            @foreach ($listaUsuarios as $u)
                                                <option value="{{ $u->id }}" {{ (isset($modulo) && in_array($u->id, $modulo->visible_users ?? [])) ? 'selected' : '' }}>
                                                    {{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Estado</label>
                                        <div class="d-flex align-items-center p-2 border rounded bg-light">
                                            <label class="switch me-3">
                                                <input type="checkbox" name="is_active" checked>
                                                <span class="slider round"></span>
                                            </label>
                                            <span class="text-muted">Módulo visible para los usuarios seleccionados</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="content-pasos">
                            <div class="form-section-card shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Ruta de Aprendizaje</h5>
                                    <span class="badge bg-soft-primary text-primary">Define los pasos secuenciales</span>
                                </div>
                                <div id="steps-container">
                                </div>
                                <button type="button" class="btn floating-add-btn w-100 mt-3" id="addStep">
                                    <i class="fas fa-plus-circle me-2"></i> Agregar Nuevo Paso a la Ruta
                                </button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="content-recursos">
                            <div class="row g-4">
                                <div class="col-md-7">
                                    <div class="form-section-card shadow-sm h-100">
                                        <h5 class="fw-bold mb-4">Recursos Descargables</h5>

                                        <div class="mb-3">
                                            <label class="form-label text-muted small">Subir nuevos archivos (PDF, Word,
                                                Excel)</label>
                                            <input type="file" name="recursos[]" class="form-control" multiple>
                                        </div>

                                        @if(isset($modulo) && $modulo->recursos->count() > 0)
                                            <div class="mt-4">
                                                <h6 class="fw-bold mb-3">Recursos Actuales:</h6>
                                                <div class="list-group list-group-flush border rounded">
                                                    @foreach($modulo->recursos as $recurso)
                                                        <div class="list-group-item d-flex justify-content-between align-items-center bg-light py-2"
                                                            id="recurso-item-{{ $recurso->id }}">
                                                            <div class="d-flex align-items-center">
                                                                @php
                                                                    $ext = pathinfo($recurso->file_path, PATHINFO_EXTENSION);
                                                                    $icon = match ($ext) {
                                                                        'pdf' => 'fa-file-pdf text-danger',
                                                                        'doc', 'docx' => 'fa-file-word text-primary',
                                                                        'xls', 'xlsx' => 'fa-file-excel text-success',
                                                                        default => 'fa-file text-muted'
                                                                    };
                                                                @endphp
                                                                <i class="fas {{ $icon }} fa-lg me-3"></i>
                                                                <div class="text-truncate" style="max-width: 250px;">
                                                                    <a href="{{ asset('storage/' . $recurso->file_path) }}"
                                                                        target="_blank"
                                                                        class="text-decoration-none text-dark fw-bold small">
                                                                        {{ $recurso->original_name ?? basename($recurso->file_path) }}
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <button type="button"
                                                                class="btn btn-link text-danger p-0 delete-recurso-btn"
                                                                data-id="{{ $recurso->id }}">
                                                                <i class="fas fa-times-circle"></i>
                                                            </button>

                                                            <input type="hidden" name="delete_recursos[]"
                                                                id="input-delete-recurso-{{ $recurso->id }}" value="" disabled>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-4">
                                            <h6 class="fw-bold">Enlaces Externos (Genially)</h6>
                                            <div class="input-group-modern mb-2">
                                                <input type="text" name="genilay_recursos_link1" class="form-control"
                                                    placeholder="Link 1"
                                                    value="{{ $modulo->genilay_recursos_link1 ?? '' }}">
                                            </div>
                                            <div class="input-group-modern">
                                                <input type="text" name="genilay_recursos_link2" class="form-control"
                                                    placeholder="Link 2"
                                                    value="{{ $modulo->genilay_recursos_link2 ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-section-card shadow-sm h-100">
                                        <h5 class="fw-bold mb-4">Galería de Imágenes</h5>
                                        <div id="imagenes-container"></div>
                                        <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2"
                                            id="addImagen">+ Agregar Imagen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="content-examen">
                            <div class="form-section-card shadow-sm border-start border-4 border-success">
                                <h5 class="fw-bold mb-4">Configuración del Examen</h5>
                                <div id="preguntas-container">
                                </div>
                                <button type="button" class="btn btn-success w-100 py-3 rounded-3 mt-3" id="addPregunta">
                                    <i class="fas fa-question-circle me-2"></i> Añadir Pregunta de Selección Múltiple
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.existingData = {
            steps: @json($modulo->steps ?? []),
            imagenes: @json($modulo->imagenes ?? []),
            preguntas: @json($modulo->preguntas ?? [])
        };
    </script>

    <script src="{{ asset('js/admin/modulos-editor.js') }}"></script>



@endsection