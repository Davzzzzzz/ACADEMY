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
                <a href="{{ route('admin.niveles.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-layers"></i> Niveles
                </a>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            <h1>Niveles</h1>

            <a href="{{ route('admin.niveles.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Crear Nivel
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Nivel</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($niveles as $nivel)
                        <tr>
                            <td>{{ $nivel->id_nivel }}</td>
                            <td>{{ $nivel->nombre_nivel }}</td>
                            <td>{{ $nivel->descripcion }}</td>
                            <td>
                                <a href="{{ route('admin.niveles.show', $nivel->id_nivel) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('admin.niveles.edit', $nivel->id_nivel) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.niveles.destroy', $nivel->id_nivel) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este nivel?')">
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
