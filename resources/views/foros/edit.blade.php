@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Editar Foro</h4>

    <form method="POST" action="{{ route('foros.update', $foro->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required value="{{ old('titulo', $foro->titulo) }}">
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="5" required>{{ old('contenido', $foro->contenido) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="{{ route('foros.show', $foro->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
