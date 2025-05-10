@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Crear Nuevo Foro</h4>

    <form method="POST" action="{{ route('foros.store') }}">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Publicar</button>
        <a href="{{ route('foros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
