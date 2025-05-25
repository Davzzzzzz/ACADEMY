@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Ejercicio</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.ejercicios.update', $ejercicio->id_ejercicio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Lección --}}
        <div class="form-group">
            <label for="id_leccion">Lección</label>
            <select id="id_leccion" name="id_leccion" class="form-control" required>
                <option value="">Selecciona una lección</option>
                @foreach($lecciones as $leccion)
                    <option value="{{ $leccion->id_leccion }}" {{ $ejercicio->id_leccion == $leccion->id_leccion ? 'selected' : '' }}>
                        {{ $leccion->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tipo de pregunta --}}
        <div class="form-group">
            <label for="id_tipo_pregunta">Tipo de Pregunta</label>
            <input type="number" id="id_tipo_pregunta" name="id_tipo_pregunta" class="form-control" value="{{ $ejercicio->id_tipo_pregunta }}" required>
        </div>

        {{-- Pregunta --}}
        <div class="form-group">
            <label for="pregunta">Pregunta</label>
            <input type="text" id="pregunta" name="pregunta" class="form-control" value="{{ $ejercicio->pregunta }}" required>
        </div>

        {{-- Imagen de la pregunta --}}
        <div class="form-group">
            <label for="imagen_pregunta">Imagen de la pregunta (opcional)</label>
            @if($ejercicio->imagen_pregunta)
                <div class="mb-2">
                    <img src="{{ asset($ejercicio->imagen_pregunta) }}" alt="Imagen actual" width="100">
                </div>
            @endif
            <input type="file" id="imagen_pregunta" name="imagen_pregunta" class="form-control">
        </div>

        {{-- Opciones --}}
        <div class="form-group">
            <label>Opciones</label>
            <div id="opciones-container">
                @if(is_array($ejercicio->opciones))
                    @foreach($ejercicio->opciones as $index => $opcion)
                        <div class="mb-3 opcion-item">
                            <input type="text" name="opciones_texto[]" class="form-control mb-1" placeholder="Texto de opción (opcional)" value="{{ $opcion['label'] ?? '' }}">

                            @if(!empty($opcion['imagen']))
                                <div class="mb-1">
                                    <img src="{{ asset($opcion['imagen']) }}" alt="Opción Imagen" width="80">
                                </div>
                            @endif

                            <input type="file" name="opciones_imagen[]" class="form-control mb-1">
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarOpcion()">Agregar otra opción</button>
        </div>

        {{-- Respuesta correcta --}}
        <div class="form-group">
            <label for="respuesta_correcta">Respuesta Correcta (texto o nombre de archivo)</label>
            <input type="text" id="respuesta_correcta" name="respuesta_correcta" class="form-control" value="{{ $ejercicio->respuesta_correcta }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.ejercicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
function agregarOpcion() {
    const container = document.getElementById('opciones-container');
    const div = document.createElement('div');
    div.className = 'mb-3 opcion-item';
    div.innerHTML = `
        <input type="text" name="opciones_texto[]" class="form-control mb-1" placeholder="Texto de opción (opcional)">
        <input type="file" name="opciones_imagen[]" class="form-control mb-1">
    `;
    container.appendChild(div);
}
</script>
@endsection
