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
                <a href="{{ route('admin.lecciones.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-journal-bookmark"></i> Lecciones
                </a>
                <a href="{{ route('admin.ejercicios.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-pencil-square"></i> Ejercicios
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Lecciones</h1>

            <a href="{{ route('admin.lecciones.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Crear Lección
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nivel</th>
                        <th>Título</th>
                        <th>Contenido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lecciones as $leccion)
                        <tr>
                            <td>{{ $leccion->id_leccion }}</td>
                            <td>{{ $leccion->nivel->nombre ?? 'Sin nivel' }}</td>
                            <td>{{ $leccion->titulo }}</td>
                            <td>{{ Str::limit($leccion->contenido, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.lecciones.show', $leccion->id_leccion) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.lecciones.edit', $leccion->id_leccion) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.lecciones.destroy', $leccion->id_leccion) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar esta lección?')">
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
