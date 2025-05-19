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

        {{-- Imagen --}}
        <div class="form-group">
            <label for="imagen_pregunta">Imagen (opcional)</label>
            <input type="file" id="imagen_pregunta" name="imagen_pregunta" class="form-control">
        </div>

        {{-- Opciones --}}
        <div class="form-group">
            <label for="opciones-container">Opciones</label>
            <div id="opciones-container">
                <input type="text" name="opciones[]" class="form-control mb-2" placeholder="Opción 1">
                <input type="text" name="opciones[]" class="form-control mb-2" placeholder="Opción 2">
                <input type="text" name="opciones[]" class="form-control mb-2" placeholder="Opción 3">
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarOpcion()">Agregar opción</button>
        </div>

        {{-- Respuesta correcta --}}
        <div class="form-group">
            <label for="respuesta_correcta">Respuesta Correcta</label>
            <input type="text" id="respuesta_correcta" name="respuesta_correcta" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.ejercicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
function agregarOpcion() {
    const container = document.getElementById('opciones-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'opciones[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Otra opción';
    container.appendChild(input);
}
</script>
@endsection
