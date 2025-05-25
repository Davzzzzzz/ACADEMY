@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Nivel</h1>

    {{-- Mensajes de error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de edición --}}
    <form action="{{ route('admin.niveles.update', $nivel->id_nivel) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre del nivel --}}
        <div class="form-group mb-3">
            <label for="nombre_nivel">Nombre del Nivel</label>
            <input type="text" name="nombre_nivel" id="nombre_nivel" class="form-control"
                   value="{{ old('nombre_nivel', $nivel->nombre_nivel) }}" required>
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required>{{ old('descripcion', $nivel->descripcion) }}</textarea>
        </div>

        {{-- Botones --}}
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.niveles.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
