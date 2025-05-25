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
            <h1>Comentarios</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Botón para agregar comentario --}}
            <div class="mb-3">
                <a href="{{ route('admin.comentarios.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Agregar Comentario
                </a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Foro</th>
                        <th>Contenido</th>
                        <th>Fecha Publicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comentarios as $comentario)
                        <tr>
                            <td>{{ $comentario->id }}</td>
                            <td>{{ $comentario->usuario ? $comentario->usuario->nombre : 'Sin usuario' }}</td>
                            <td>{{ $comentario->foro ? $comentario->foro->titulo : 'Sin foro' }}</td>
                            <td>{{ $comentario->contenido }}</td>
                            <td>{{ $comentario->fecha_publicacion ? $comentario->fecha_publicacion->format('d/m/Y H:i') : 'No definida' }}</td>
                            <td>
                                <a href="{{ route('admin.comentarios.edit', $comentario->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.comentarios.destroy', $comentario->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este comentario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small>
                        Mostrando
                        {{ $comentarios->firstItem() ?? 0 }}
                        -
                        {{ $comentarios->lastItem() ?? 0 }}
                        de
                        {{ $comentarios->total() }}
                        comentarios
                    </small>
                </div>
                <div>
                    {{ $comentarios->links('pagination::bootstrap-5') }}
                </div>
            </div>
</div>
@endsection
