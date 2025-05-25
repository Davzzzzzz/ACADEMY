@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Ejercicio</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ejercicios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Lección --}}
        <div class="form-group">
            <label for="id_leccion">Lección</label>
            <select id="id_leccion" name="id_leccion" class="form-control" required>
                <option value="">Selecciona una lección</option>
                @foreach($lecciones as $leccion)
                    <option value="{{ $leccion->id_leccion }}">{{ $leccion->titulo }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tipo de pregunta --}}
        <div class="form-group">
            <label for="id_tipo_pregunta">Tipo de Pregunta</label>
            <input type="number" id="id_tipo_pregunta" name="id_tipo_pregunta" class="form-control" required>
        </div>

        {{-- Pregunta --}}
        <div class="form-group">
            <label for="pregunta">Pregunta</label>
            <input type="text" id="pregunta" name="pregunta" class="form-control" required>
        </div>

        {{-- Imagen pregunta --}}
        <div class="form-group">
            <label for="imagen_pregunta">Imagen de la pregunta (opcional)</label>
            <input type="file" id="imagen_pregunta" name="imagen_pregunta" class="form-control mb-1">
            <input type="text" id="nombre_archivo_pregunta" name="nombre_archivo_pregunta" class="form-control" placeholder="Nombre del archivo para imagen pregunta (ejemplo: c.png)">
        </div>

        {{-- Opciones --}}
        <div class="form-group">
            <label>Opciones</label>
            <div id="opciones-container">
                <div class="mb-3">
                    <input type="text" name="opciones_texto[]" class="form-control mb-1" placeholder="Texto de opción (opcional)">
                    <input type="file" name="opciones_imagen[]" class="form-control mb-1">
                    <input type="text" name="nombre_archivo_opciones[]" class="form-control" placeholder="Nombre archivo para imagen opción (ejemplo: opcion1.png)">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarOpcion()">Agregar otra opción</button>
        </div>

        {{-- Respuesta correcta --}}
        <div class="form-group">
            <label for="respuesta_correcta">Respuesta Correcta (texto o nombre de archivo)</label>
            <input type="text" id="respuesta_correcta" name="respuesta_correcta" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.ejercicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
function agregarOpcion() {
    const container = document.getElementById('opciones-container');
    const div = document.createElement('div');
    div.className = 'mb-3';
    div.innerHTML = `
        <input type="text" name="opciones_texto[]" class="form-control mb-1" placeholder="Texto de opción (opcional)">
        <input type="file" name="opciones_imagen[]" class="form-control mb-1">
        <input type="text" name="nombre_archivo_opciones[]" class="form-control" placeholder="Nombre archivo para imagen opción (ejemplo: opcion2.png)">
    `;
    container.appendChild(div);
}
</script>
@endsection
