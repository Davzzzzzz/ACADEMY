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
                <a href="{{ route('admin.usuarios.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <a href="{{ route('admin.reportes.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-flag"></i> Reportes
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Crear Reporte</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.reportes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">ID del Usuario</label>
                    <input type="number" name="id_usuario" id="id_usuario" class="form-control" value="{{ old('id_usuario') }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
                </div>
                <!-- Campo de fecha_reporte -->
    <div class="mb-3">
        <label for="fecha_reporte" class="form-label">Fecha del reporte</label>
        <input type="date" name="fecha_reporte" id="fecha_reporte" class="form-control" value="{{ old('fecha_reporte') }}" required>
    </div>
                <button type="submit" class="btn btn-success">Guardar Reporte</button>
                <a href="{{ route('admin.reportes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
