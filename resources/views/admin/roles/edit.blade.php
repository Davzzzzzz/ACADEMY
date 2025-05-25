@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Rol</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $rol->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del Rol</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                   value="{{ old('nombre', $rol->nombre) }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Rol</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
