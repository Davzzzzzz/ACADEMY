@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nivel</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.niveles.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre_nivel">Nombre del Nivel</label>
            <select name="nombre_nivel" id="nombre_nivel" class="form-control" required>
                <option value="" disabled selected>Selecciona un nivel</option>
                <option value="Principiante" {{ old('nombre_nivel') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                <option value="Intermedio" {{ old('nombre_nivel') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                <option value="Avanzado" {{ old('nombre_nivel') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="descripcion">Descripción (opcional)</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Crear Nivel</button>
        <a href="{{ route('admin.niveles.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
