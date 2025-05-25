@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">
        {{ isset($parentId) ? 'Responder a una publicación' : 'Crear nueva publicación' }}
    </h2>

    <div class="mb-3">
        <strong>Foro:</strong> {{ $foro->titulo }}
    </div>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Errores de validación:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para crear publicación --}}
    <form action="{{ route('publicaciones.store') }}" method="POST">
        @csrf

        {{-- Campo oculto: ID del foro --}}
        <input type="hidden" name="foro_id" value="{{ $foro->id }}">

        {{-- Campo oculto: ID de la publicación padre (si aplica) --}}
        @if (isset($parentId))
            <input type="hidden" name="parent_id" value="{{ $parentId }}">
        @endif

        {{-- Contenido --}}
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido de la publicación</label>
            <textarea
                name="contenido"
                id="contenido"
                rows="5"
                class="form-control @error('contenido') is-invalid @enderror"
                required>{{ old('contenido') }}</textarea>

            @error('contenido')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botón --}}
        <button type="submit" class="btn btn-primary">
            {{ isset($parentId) ? 'Enviar respuesta' : 'Publicar' }}
        </button>
    </form>
</div>
@endsection
