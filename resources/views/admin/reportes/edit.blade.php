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
            <h1>Editar Reporte</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.reportes.update', $reporte->id_reporte) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ID del Reporte</label>
                    <input type="text" class="form-control" value="{{ $reporte->id_reporte }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario que reporta</label>
                    <select name="id_usuario" id="id_usuario" class="form-control" required>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('id_usuario', $reporte->id_usuario) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre }} ({{ $usuario->correo }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentario reportado</label>
                    <input type="text" class="form-control"
                        value="{{ $reporte->comentario->contenido ?? 'Comentario eliminado' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Motivo del reporte</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $reporte->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_reporte" class="form-label">Fecha del reporte</label>
                    <input type="date" name="fecha_reporte" id="fecha_reporte" class="form-control"
                        value="{{ old('fecha_reporte', \Carbon\Carbon::parse($reporte->fecha_reporte)->format('Y-m-d')) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Reporte</button>
                <a href="{{ route('admin.reportes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
