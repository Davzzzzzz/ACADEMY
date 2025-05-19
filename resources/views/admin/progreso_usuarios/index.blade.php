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
                <a href="{{ route('admin.progresousuario.index') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-bar-chart-steps"></i> Progreso Usuarios
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Progreso de Usuarios</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Botón de agregar --}}
            <div class="mb-3">
                <a href="{{ route('admin.progresousuario.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Agregar Progreso
                </a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nivel</th>
                        <th>Lección Actual</th>
                        <th>Ejercicios Completados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progresos as $progreso)
                        <tr>
                            <td>{{ $progreso->id_progreso }}</td>
                            <td>{{ $progreso->usuario->nombre ?? 'Sin usuario' }}</td>
                            <td>{{ $progreso->nivel->nombre_nivel ?? 'Sin nivel' }}</td>
                            <td>{{ $progreso->leccion->titulo ?? 'Sin lección' }}</td>
                            <td>{{ $progreso->ejercicios_completados }}</td>
                            <td>
                                <a href="{{ route('admin.progresousuario.edit', $progreso->id_progreso) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.progresousuario.destroy', $progreso->id_progreso) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este progreso?')">
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
