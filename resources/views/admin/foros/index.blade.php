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

        {{-- Contenido principal: Foros --}}
        <div class="col-md-9">
            <h1>Foros</h1>

            <a href="{{ route('admin.foros.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Crear Foro
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foros as $foro)
                        <tr>
                            <td>{{ $foro->id }}</td>
                            <td>{{ $foro->titulo }}</td>
                            <td>{{ $foro->descripcion }}</td>
                            <td>{{ $foro->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.foros.edit', $foro->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('foros.destroy', $foro->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar foro?')">
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
                        {{ $foros->firstItem() ?? 0 }}
                        -
                        {{ $foros->lastItem() ?? 0 }}
                        de
                        {{ $foros->total() }}
                        foros
                    </small>
                </div>
                <div>
                    {{ $foros->links('pagination::bootstrap-5') }}
                </div>
            </div>
</div>
@endsection
