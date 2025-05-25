@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Panel lateral --}}
        <div class="col-md-3">
            <div class="list-group mb-4">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-speedometer2"></i> Panel de Administración
                </a>
                <a href="{{ route('admin.usuarios.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-people"></i> Usuarios
                </a>
                <a href="{{ route('admin.foros.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-chat-left-text"></i> Foros
                </a>
                <a href="{{ route('admin.comentarios.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-chat-dots"></i> Comentarios
                </a>
                <a href="{{ route('admin.reportes.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-flag"></i> Reportes
                </a>
                <a href="{{ route('admin.progresousuario.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-bar-chart-line"></i> Progreso Usuario
                </a>
                <a href="{{ route('admin.rachas.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-fire"></i> Racha
                </a>
                <a href="{{ route('admin.ejercicios.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-pencil-square"></i> Ejercicios
                </a>
                <a href="{{ route('admin.lecciones.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-journal-bookmark"></i> Lecciones
                </a>
                <a href="{{ route('admin.niveles.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-trophy"></i> Niveles
                </a>
                <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-person-badge"></i> Roles
                </a>
            </div>
        </div>

         {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Reportes</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
                <a href="{{ route('admin.reportes.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Agregar Reporte
                </a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario que reporta</th>
                        <th>Comentario reportado</th>
                        <th>Autor comentario</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportes as $reporte)
                        <tr>
                            <td>{{ $reporte->id_reporte }}</td>
                            <td>{{ $reporte->usuario->nombre ?? 'Sin usuario' }}</td>
                            <td>
                                @if($reporte->comentario)
                                    <span title="{{ $reporte->comentario->contenido }}">
                                        {{ Str::limit($reporte->comentario->contenido, 40) }}
                                    </span>
                                @else
                                    <span class="text-muted">Comentario eliminado</span>
                                @endif
                            </td>
                            <td>
                                {{ $reporte->comentario->usuario->nombre ?? 'Sin autor' }}
                            </td>
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
                    @empty
                        <tr>
                            <td colspan="7">No hay reportes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
                        </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small>
                        Mostrando
                        {{ $reportes->firstItem() ?? 0 }}
                        -
                        {{ $reportes->lastItem() ?? 0 }}
                        de
                        {{ $reportes->total() }}
                        reportes
                    </small>
                </div>
                <div>
                    {{ $reportes->links('pagination::bootstrap-5') }}
                </div>
            </div>
</div>
@endsection
