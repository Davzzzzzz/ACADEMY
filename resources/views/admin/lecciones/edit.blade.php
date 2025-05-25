@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Lección</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.lecciones.update', $leccion->id_leccion) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nivel --}}
        <div class="form-group">
            <label for="id_nivel">Nivel</label>
            <select name="id_nivel" id="id_nivel" class="form-control" required>
                <option value="">Selecciona un nivel</option>
                @foreach($niveles as $nivel)
                    <option value="{{ $nivel->id_nivel }}" {{ old('id_nivel', $leccion->id_nivel) == $nivel->id_nivel ? 'selected' : '' }}>
                        {{ $nivel->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Título --}}
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $leccion->titulo) }}" required>
        </div>

        {{-- Contenido --}}
        <div class="form-group">
            <label for="contenido">Contenido</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="5" required>{{ old('contenido', $leccion->contenido) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.lecciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
