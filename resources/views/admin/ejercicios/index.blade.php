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
            <h1>Ejercicios</h1>

            <a href="{{ route('admin.ejercicios.create') }}" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Crear Ejercicio
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lección</th>
                        <th>Pregunta</th>
                        <th>Imagen</th>
                        <th>Opciones</th>
                        <th>Respuesta Correcta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ejercicios as $ejercicio)
                        <tr>
                            <td>{{ $ejercicio->id_ejercicio }}</td>
                            <td>{{ $ejercicio->leccion->titulo ?? 'Sin lección' }}</td>
                            <td>{{ $ejercicio->pregunta }}</td>

                            {{-- Imagen de la pregunta --}}
                            <td>
                                @if($ejercicio->imagen_pregunta)
                                    <img src="{{ asset($ejercicio->imagen_pregunta) }}" alt="Imagen Pregunta" width="50">
                                @else
                                    Sin imagen
                                @endif
                            </td>

                            {{-- Opciones --}}
                            <td>
                                @if(is_array($ejercicio->opciones))
                                    <ul style="padding-left: 1rem;">
                                        @foreach($ejercicio->opciones as $opcion)
                                            <li>
                                                @if(!empty($opcion['imagen']))
                                                    <img src="{{ asset($opcion['imagen']) }}" alt="Opción Imagen" width="40" class="me-1">
                                                @endif
                                                {{ $opcion['label'] ?? 'Sin texto' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>Sin opciones</span>
                                @endif
                            </td>

                            {{-- Respuesta correcta --}}
                            <td>{{ $ejercicio->respuesta_correcta }}</td>

                            {{-- Acciones --}}
                            <td>
                                <a href="{{ route('admin.ejercicios.edit', $ejercicio->id_ejercicio) }}" class="btn btn-sm btn-primary mb-1">Editar</a>
                                <form action="{{ route('admin.ejercicios.destroy', $ejercicio->id_ejercicio) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este ejercicio?')">
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
                        {{ $ejercicios->firstItem() ?? 0 }}
                        -
                        {{ $ejercicios->lastItem() ?? 0 }}
                        de
                        {{ $ejercicios->total() }}
                        ejercicios
                    </small>
                </div>
                <div>
                    {{ $ejercicios->links('pagination::bootstrap-5') }}
                </div>
            </div>
</div>
@endsection
