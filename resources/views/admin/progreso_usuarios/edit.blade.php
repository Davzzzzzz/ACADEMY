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
                <a href="{{ route('admin.progresousuario.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-bar-chart-steps"></i> Progreso Usuarios
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Editar Progreso de Usuario</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.progresousuario.update', $progreso->id_progreso) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario</label>
                    <select name="id_usuario" id="id_usuario" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $progreso->id_usuario == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_nivel" class="form-label">Nivel</label>
                    <select name="id_nivel" id="id_nivel" class="form-select" required>
                        <option value="">Seleccione un nivel</option>
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel->id_nivel }}" {{ $progreso->id_nivel == $nivel->id_nivel ? 'selected' : '' }}>
                                {{ $nivel->nombre_nivel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_leccion_actual" class="form-label">Lección Actual</label>
                    <select name="id_leccion_actual" id="id_leccion_actual" class="form-select">
                        <option value="">Seleccione una lección</option>
                        @foreach($lecciones as $leccion)
                            <option value="{{ $leccion->id_leccion }}" {{ $progreso->id_leccion_actual == $leccion->id_leccion ? 'selected' : '' }}>
                                {{ $leccion->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ejercicios_completados" class="form-label">Ejercicios Completados</label>
                    <input type="number" name="ejercicios_completados" id="ejercicios_completados" class="form-control" value="{{ $progreso->ejercicios_completados }}" min="0" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Actualizar
                </button>
                <a href="{{ route('admin.progresousuario.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
