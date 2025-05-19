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
                            <td>
    @if($ejercicio->imagen_pregunta)
        <img src="{{ url($ejercicio->imagen_pregunta) }}" alt="Imagen Pregunta" width="50">
    @else
        Sin imagen
    @endif
</td>

                            <td>
                                @if(is_array($ejercicio->opciones))
                                    <ul>
                                        @foreach($ejercicio->opciones as $opcion)
                                            <li>{{ $opcion['label'] ?? 'Sin etiqueta' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>Sin opciones</span>
                                @endif
                            </td>
                            <td>{{ $ejercicio->respuesta_correcta }}</td>
                            <td>
                                <a href="{{ route('admin.ejercicios.edit', $ejercicio->id_ejercicio) }}" class="btn btn-sm btn-primary">Editar</a>
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

        </div>
    </div>
</div>
@endsection
