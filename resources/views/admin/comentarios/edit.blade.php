@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Comentario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.comentarios.update', $comentario->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Selección de usuario --}}
        <div class="mb-3">
            <label for="id_usuario" class="form-label">Usuario</label>
            <select name="id_usuario" id="id_usuario" class="form-select" required>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $comentario->id_usuario == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Selección de foro --}}
        <div class="mb-3">
            <label for="foro_id" class="form-label">Foro</label>
            <select name="foro_id" id="foro_id" class="form-select" required>
                @foreach ($foros as $foro)
                    <option value="{{ $foro->id }}" {{ $comentario->foro_id == $foro->id ? 'selected' : '' }}>
                        {{ $foro->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Contenido --}}
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="4" required>{{ old('contenido', $comentario->contenido) }}</textarea>
        </div>

        {{-- Fecha de publicación --}}
        <div class="mb-3">
            <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
            <input type="datetime-local" name="fecha_publicacion" id="fecha_publicacion" class="form-control"
                   value="{{ old('fecha_publicacion', $comentario->fecha_publicacion ? $comentario->fecha_publicacion->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Actualizar Comentario</button>
        <a href="{{ route('admin.comentarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
