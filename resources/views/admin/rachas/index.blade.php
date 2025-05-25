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
            <h1>Rachas de Usuarios</h1>

            <a href="{{ route('admin.rachas.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Nueva Racha
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Racha</th>
                        <th>Usuario</th>
                        <th>Días consecutivos</th>
                        <th>Última Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rachas as $racha)
                        <tr>
                            <td>{{ $racha->id_racha }}</td>
                            <td>{{ $racha->usuario->nombre ?? 'Sin usuario' }}</td>
                            <td>{{ $racha->dias_consecutivos }}</td>
                            <td>{{ $racha->ultima_fecha ? \Carbon\Carbon::parse($racha->ultima_fecha)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.rachas.edit', $racha->id_racha) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('admin.rachas.destroy', $racha->id_racha) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar racha?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
    <div>
        <small>
            Mostrando
            {{ $rachas->firstItem() ?? 0 }}
            -
            {{ $rachas->lastItem() ?? 0 }}
            de
            {{ $rachas->total() }}
            rachas
        </small>
    </div>
    <div>
        {{ $rachas->links('pagination::bootstrap-5') }}
    </div>
</div>
        </div>
    </div>
</div>
@endsection
