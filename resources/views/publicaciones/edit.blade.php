@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Editar Publicación</h4>

    <form method="POST" action="{{ route('publicaciones.update', $publicacion->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <textarea name="contenido" class="form-control" rows="4" required>{{ old('contenido', $publicacion->contenido) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
