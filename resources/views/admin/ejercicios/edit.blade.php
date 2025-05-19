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
            <select name="id_leccion" class="form-control" required>
                <option value="">Selecciona una lección</option>
                @foreach($lecciones as $leccion)
                    <option value="{{ $leccion->id_leccion }}" {{ $leccion->id_leccion == $ejercicio->id_leccion ? 'selected' : '' }}>
                        {{ $leccion->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tipo de pregunta --}}
        <div class="form-group">
            <label for="id_tipo_pregunta">Tipo de Pregunta</label>
            <input type="number" name="id_tipo_pregunta" class="form-control" value="{{ old('id_tipo_pregunta', $ejercicio->id_tipo_pregunta) }}" required>
        </div>

        {{-- Pregunta --}}
        <div class="form-group">
            <label for="pregunta">Pregunta</label>
            <input type="text" name="pregunta" class="form-control" value="{{ old('pregunta', $ejercicio->pregunta) }}" required>
        </div>

        {{-- Imagen actual --}}
        <div class="form-group">
            <label>Imagen actual</label><br>
            @if($ejercicio->imagen_pregunta)
                <img src="{{ asset('storage/' . $ejercicio->imagen_pregunta) }}" alt="Imagen Pregunta" width="100">
            @else
                <span>Sin imagen</span>
            @endif
        </div>

        {{-- Cambiar imagen --}}
        <div class="form-group">
            <label for="imagen_pregunta">Cambiar Imagen (opcional)</label>
            <input type="file" name="imagen_pregunta" class="form-control">
        </div>

        {{-- Opciones --}}
        <div class="form-group">
            <label for="opciones">Opciones</label>
            <div id="opciones-container">
                @php
                    if(old('opciones')) {
                        $opciones = old('opciones');
                    } else {
                        $opciones = collect($ejercicio->opciones ?? [])->pluck('label')->toArray();
                    }
                @endphp

                @if(is_array($opciones) && count($opciones) > 0)
                    @foreach($opciones as $index => $opcion)
                        <input type="text" name="opciones[]" class="form-control mb-2" value="{{ $opcion }}" placeholder="Opción {{ $index + 1 }}" required>
                    @endforeach
                @else
                    {{-- Al menos 3 inputs por defecto --}}
                    <input type="text" name="opciones[]" class="form-control mb-2" placeholder="Opción 1" required>
                    <input type="text" name="opciones[]" class="form-control mb-2" placeholder="Opción 2" required>
                    <input type="text" name="opciones[]" class="form-control mb-2" placeholder="Opción 3" required>
                @endif
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="agregarOpcion()">Agregar opción</button>
        </div>

        {{-- Respuesta correcta --}}
        <div class="form-group">
            <label for="respuesta_correcta">Respuesta Correcta</label>
            <input type="text" name="respuesta_correcta" class="form-control" value="{{ old('respuesta_correcta', $ejercicio->respuesta_correcta) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
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
    input.required = true;
    container.appendChild(input);
}
</script>
@endsection
