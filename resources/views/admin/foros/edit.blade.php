@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Panel lateral --}}
        <div class="col-md-3">
            <div class="list-group mb-4">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-speedometer2"></i> Panel de Administración
                </a>
                <a href="{{ route('admin.foros.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-chat-left-text"></i> Foros
                </a>
                {{-- Puedes seguir agregando más accesos rápidos aquí --}}
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h2>Editar Foro</h2>

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>¡Ups! Algo salió mal:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario para editar foro --}}
            <form action="{{ route('admin.foros.update', $foro->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- método PUT para actualizar --}}

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $foro->titulo) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required>{{ old('descripcion', $foro->descripcion) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.foros.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>

    </div>
</div>
@endsection
