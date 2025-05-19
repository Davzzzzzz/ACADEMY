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
            <h1>Editar Racha</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rachas.update', $racha->id_racha) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario</label>
                    <select name="id_usuario" id="id_usuario" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $usuario->id == $racha->id_usuario ? 'selected' : '' }}>
                                {{ $usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dias_consecutivos" class="form-label">Días consecutivos</label>
                    <input type="number" name="dias_consecutivos" id="dias_consecutivos" class="form-control" value="{{ $racha->dias_consecutivos }}" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="ultima_fecha" class="form-label">Última Fecha</label>
                    <input type="date" name="ultima_fecha" id="ultima_fecha" class="form-control" value="{{ \Carbon\Carbon::parse($racha->ultima_fecha)->format('Y-m-d') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Actualizar
                </button>
                <a href="{{ route('admin.rachas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
