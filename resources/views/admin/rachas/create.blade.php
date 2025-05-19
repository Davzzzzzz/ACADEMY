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
                <a href="{{ route('admin.rachas.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-fire"></i> Rachas
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Crear Nueva Racha</h1>

            {{-- Mensajes de error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('admin.rachas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario</label>
                    <select name="id_usuario" id="id_usuario" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dias_consecutivos" class="form-label">Días consecutivos</label>
                    <input type="number" name="dias_consecutivos" id="dias_consecutivos" class="form-control" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="ultima_fecha" class="form-label">Última fecha (opcional)</label>
                    <input type="date" name="ultima_fecha" id="ultima_fecha" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Guardar Racha
                </button>
                <a href="{{ route('admin.rachas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
