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
                <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-person-badge"></i> Roles
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Roles</h1>

            <a href="{{ route('admin.roles.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Crear Rol
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuarios Asignados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td>{{ $rol->nombre }}</td>
                            <td>{{ $rol->usuarios->count() }}</td>
                            <td>
                                <a href="{{ route('admin.roles.show', $rol->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.roles.edit', $rol->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.roles.destroy', $rol->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este rol?')">
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
