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
            <h1>Reportes</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Botón agregar reporte a la izquierda --}}
            <div class="mb-3">
                <a href="{{ route('admin.reportes.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Agregar Reporte
                </a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Descripción</th>
                        <th>Fecha de Reporte</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportes as $reporte)
                        <tr>
                            <td>{{ $reporte->id_reporte }}</td>
                            <td>{{ $reporte->usuario->nombre ?? 'Sin usuario' }}</td>
                            <td>{{ $reporte->descripcion }}</td>
                            <td>{{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.reportes.edit', $reporte->id_reporte) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.reportes.destroy', $reporte->id_reporte) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este reporte?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $reportes->links() }}
        </div>
    </div>
</div>
@endsection
