/**
 * EDITOR DINÁMICO DE MÓDULOS
 * Soporta: Pasos, Tips, Imágenes y Preguntas (Creación y Edición)
 */

let stepIndex = 0;
let imagenIndex = 0;
let preguntaIndex = 0;

/* -------------------------------------------------
   1. GESTIÓN DE PASOS (Ruta de Aprendizaje)
   ------------------------------------------------- */

function renderStep(data = {}) {
    const container = document.getElementById('steps-container');
    const sIdx = stepIndex;
    const div = document.createElement('div');

    const stepIdHidden = data.id ? `<input type="hidden" name="steps[${sIdx}][id]" value="${data.id}">` : '';

    div.classList.add('step-card', 'p-4', 'mb-4', 'border', 'rounded-3', 'bg-white', 'shadow-sm', 'position-relative');
    div.style.borderLeft = "5px solid #0d6efd";

    div.innerHTML = `
        ${stepIdHidden}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-primary mb-0">
                <i class="fas fa-route me-2"></i>Paso #${sIdx + 1} ${data.id ? '<span class="badge bg-light text-muted fw-normal small">Editando</span>' : ''}
            </h6>
            <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-step">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        <div class="row g-3">
            <div class="col-md-12">
                <label class="small fw-bold text-muted">Descripción del Paso</label>
                <input type="text" name="steps[${sIdx}][text]" value="${data.text || ''}" class="form-control" placeholder="Ej: Ingresar credenciales...">
            </div>
            <div class="col-md-6">
                <label class="small fw-bold text-muted">Ícono</label>
                <select name="steps[${sIdx}][icon]" class="form-select">
                    <option value="fa-right-to-bracket" ${data.icon === 'fa-right-to-bracket' ? 'selected' : ''}>🔑 Ingreso</option>
                    <option value="fa-building" ${data.icon === 'fa-building' ? 'selected' : ''}>🏢 Predio</option>
                    <option value="fa-magnifying-glass" ${data.icon === 'fa-magnifying-glass' ? 'selected' : ''}>🔍 Buscar</option>
                    <option value="fa-people-roof" ${data.icon === 'fa-people-roof' ? 'selected' : ''}>👨‍👩‍👧 Familia</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="small fw-bold text-muted">Tipo de Contenido</label>
                <select name="steps[${sIdx}][type]" class="form-select">
                    <option value="" ${!data.type ? 'selected' : ''}>Sin archivo</option>
                    <option value="image" ${data.type === 'image' ? 'selected' : ''}>Imagen</option>
                    <option value="video" ${data.type === 'video' ? 'selected' : ''}>Video</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="small fw-bold text-muted">Archivo/Recurso</label>
                ${data.file ? `<div class="mb-1 small text-primary"><i class="fas fa-paperclip"></i> Actual: ${data.file.split('/').pop()}</div>` : ''}
                <input type="file" name="steps[${sIdx}][file]" class="form-control">
            </div>
        </div>

        <div class="tips-container mt-4 p-3 bg-light rounded border">
            <label class="fw-bold mb-2 small text-uppercase">Tips del Paso</label>
            <div id="tips-list-${sIdx}"></div>
            <button type="button" class="btn btn-primary btn-sm add-tip-block" data-step="${sIdx}">+ Bloque de Tips</button>
        </div>
    `;

    container.appendChild(div);

    if (data.tips && Array.isArray(data.tips)) {
        data.tips.forEach((tipBlock, tIdx) => renderTipBlock(sIdx, tIdx, tipBlock));
    }
    stepIndex++;
}

function renderTipBlock(sIdx, tIdx, data = {}) {
    const container = document.getElementById(`tips-list-${sIdx}`);
    const block = document.createElement('div');
    block.classList.add('tip-block', 'bg-white', 'p-3', 'mb-2', 'border', 'rounded');

    block.innerHTML = `
        <div class="d-flex justify-content-between mb-2">
            <input type="text" name="steps[${sIdx}][tips][${tIdx}][title]" value="${data.title || ''}" class="form-control form-control-sm fw-bold w-75" placeholder="Título (Ej: Validación)">
            <button type="button" class="btn btn-sm btn-outline-danger remove-tip-block border-0"><i class="fas fa-times"></i></button>
        </div>
        <div class="subtips-container ps-3 border-start mb-2"></div>
        <button type="button" class="btn btn-link btn-sm text-decoration-none add-subtip" data-step="${sIdx}" data-tip="${tIdx}">+ Agregar sub-tip</button>
    `;
    container.appendChild(block);

    if (data.items && Array.isArray(data.items)) {
        data.items.forEach(val => renderSubtip(block.querySelector('.subtips-container'), sIdx, tIdx, val));
    }
}

function renderSubtip(container, sIdx, tIdx, value = "") {
    const div = document.createElement('div');
    div.classList.add('d-flex', 'mb-1');
    div.innerHTML = `
        <input type="text" name="steps[${sIdx}][tips][${tIdx}][items][]" value="${value}" class="form-control form-control-sm me-1" placeholder="Sub-tip">
        <button type="button" class="btn btn-danger btn-sm remove-subtip">x</button>
    `;
    container.appendChild(div);
}

/* -------------------------------------------------
   2. GESTIÓN DE IMÁGENES
   ------------------------------------------------- */

function renderImagen(data = {}) {
    const container = document.getElementById('imagenes-container');
    const div = document.createElement('div');
    div.classList.add('imagen-card', 'p-3', 'mb-3', 'border', 'rounded', 'bg-white');

    div.innerHTML = `
        ${data.id ? `<input type="hidden" name="imagenes[${imagenIndex}][id]" value="${data.id}">` : ''}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small fw-bold">Imagen #${imagenIndex + 1}</span>
            <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-parent">Eliminar</button>
        </div>
        ${data.file ? `<img src="/storage/${data.file}" class="img-thumbnail mb-2" style="height: 50px;">` : ''}
        <input type="file" name="imagenes[${imagenIndex}][file]" class="form-control mb-2">
        <input type="text" name="imagenes[${imagenIndex}][description]" value="${data.description || ''}" class="form-control" placeholder="Descripción">
    `;
    container.appendChild(div);
    imagenIndex++;
}

/* -------------------------------------------------
   3. GESTIÓN DE PREGUNTAS (Quiz)
   ------------------------------------------------- */

function renderPregunta(data = {}) {
    const container = document.getElementById('preguntas-container');
    const pIdx = preguntaIndex;
    const div = document.createElement('div');
    div.classList.add('pregunta-card', 'p-3', 'mb-3', 'border', 'rounded', 'bg-white');

    div.innerHTML = `
        ${data.id ? `<input type="hidden" name="preguntas[${pIdx}][id]" value="${data.id}">` : ''}
        <div class="d-flex justify-content-between mb-2">
            <label class="fw-bold">Pregunta #${pIdx + 1}</label>
            <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-parent">Eliminar</button>
        </div>
        <input type="text" name="preguntas[${pIdx}][pregunta]" value="${data.pregunta || ''}" class="form-control mb-2" placeholder="Escriba la pregunta">
        <div class="opciones-list"></div>
        <button type="button" class="btn btn-sm btn-outline-secondary add-option" data-pregunta="${pIdx}">+ Opción</button>
    `;
    container.appendChild(div);

    if (data.opciones && Array.isArray(data.opciones)) {
        data.opciones.forEach((opc, oIdx) => {
            const isCorrect = data.respuestas_correctas && data.respuestas_correctas.includes(oIdx.toString());
            renderOpcion(div.querySelector('.opciones-list'), pIdx, opc, isCorrect);
        });
    } else {
        renderOpcion(div.querySelector('.opciones-list'), pIdx); // Una opción por defecto
    }
    preguntaIndex++;
}

function renderOpcion(container, pIdx, value = "", isCorrect = false) {
    const oIdx = container.querySelectorAll('.d-flex').length;
    const div = document.createElement('div');
    div.classList.add('d-flex', 'align-items-center', 'mb-1');
    div.innerHTML = `
        <input type="text" name="preguntas[${pIdx}][opciones][]" value="${value}" class="form-control form-control-sm me-2" placeholder="Opción">
        <div class="form-check me-2">
            <input class="form-check-input" type="checkbox" name="preguntas[${pIdx}][respuestas_correctas][]" value="${oIdx}" ${isCorrect ? 'checked' : ''}>
            <label class="small text-muted">Ok</label>
        </div>
        <button type="button" class="btn btn-sm btn-light remove-parent">x</button>
    `;
    container.appendChild(div);
}

/* -------------------------------------------------
   4. DELEGACIÓN DE EVENTOS (Listeners Globales)
   ------------------------------------------------- */

document.addEventListener('click', function (e) {
    // Pasos
    if (e.target.id === 'addStep') renderStep();
    if (e.target.closest('.remove-step')) {
        if (confirm('¿Eliminar paso?')) e.target.closest('.step-card').remove();
    }

    // Tips
    if (e.target.classList.contains('add-tip-block')) {
        const sIdx = e.target.getAttribute('data-step');
        renderTipBlock(sIdx, document.getElementById(`tips-list-${sIdx}`).children.length);
    }
    if (e.target.closest('.remove-tip-block')) e.target.closest('.tip-block').remove();

    // Subtips
    if (e.target.classList.contains('add-subtip')) {
        renderSubtip(e.target.closest('.tip-block').querySelector('.subtips-container'), e.target.dataset.step, e.target.dataset.tip);
    }
    if (e.target.classList.contains('remove-subtip')) e.target.closest('.d-flex').remove();

    // Imágenes
    if (e.target.id === 'addImagen') renderImagen();

    // Preguntas
    if (e.target.id === 'addPregunta') renderPregunta();
    if (e.target.classList.contains('add-option')) {
        renderOpcion(e.target.closest('.pregunta-card').querySelector('.opciones-list'), e.target.dataset.pregunta);
    }

    // Genérico para eliminar cards simples
    if (e.target.classList.contains('remove-parent')) {
        e.target.parentElement.parentElement.remove();
    }
});

/* -------------------------------------------------
   5. INICIO: Carga de Datos desde Laravel
   ------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function () {
    // Los datos deben venir de Blade: window.existingData = { steps: [...], imagenes: [...], preguntas: [...] }
    if (window.existingData) {
        if (window.existingData.steps) window.existingData.steps.forEach(s => renderStep(s));
        if (window.existingData.imagenes) window.existingData.imagenes.forEach(i => renderImagen(i));
        if (window.existingData.preguntas) window.existingData.preguntas.forEach(p => renderPregunta(p));
    }
});