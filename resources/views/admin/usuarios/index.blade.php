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
            <h3>Usuarios Registrados</h3>

            {{-- Botón Agregar Usuario --}}
            <div class="mb-3">
                <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success">+ Agregar Usuario</a>
            </div>

            {{-- Tabla de usuarios --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Fecha de Registro</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>{{ $usuario->fecha_registro }}</td>
                            <td>{{ $usuario->rol->nombre ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-primary">Editar</a>

                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
