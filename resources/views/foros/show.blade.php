@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('foros.index') }}" class="btn btn-secondary btn-sm">&larr; Volver a foros</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">{{ $foro->titulo }}</h2>
            <p class="card-text">{{ $foro->descripcion }}</p>
            <small class="text-muted">Creado el: {{ $foro->fecha_creacion }}</small>
        </div>
    </div>

    <h4 class="mb-3">Comentarios ({{ $foro->comentarios->count() }})</h4>

    @if ($foro->comentarios->count())
        @foreach ($foro->comentarios as $comentario)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $comentario->usuario->nombre }}</strong>
                            <span class="text-muted">({{ $comentario->usuario->correo }})</span>
                        </div>
                        <small class="text-muted">{{ $comentario->fecha_publicacion }}</small>
                    </div>
                    <p class="mt-2 mb-0">{{ $comentario->contenido }}</p>

                    <!-- Botón de reportar -->
                    @auth
                    <button class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#reportarModal{{ $comentario->id }}">
                        Reportar
                    </button>

                    <!-- Modal de confirmación con descripción -->
                    <div class="modal fade" id="reportarModal{{ $comentario->id }}" tabindex="-1" aria-labelledby="reportarModalLabel{{ $comentario->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('comentarios.report', $comentario->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reportarModalLabel{{ $comentario->id }}">Reportar comentario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas reportar este comentario?</p>
                                        <div class="mb-3">
                                            <label for="descripcion{{ $comentario->id }}" class="form-label">Motivo del reporte (opcional):</label>
                                            <textarea name="descripcion" id="descripcion{{ $comentario->id }}" class="form-control" rows="3" placeholder="Describe por qué reportas este comentario"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Reportar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No hay comentarios en este foro aún.
        </div>
    @endif

    @auth
    <div class="card mt-4">
        <div class="card-body">
            <h5>Agregar un comentario</h5>
            <form action="{{ route('comentarios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="foro_id" value="{{ $foro->id }}">
                <div class="mb-3">
                    <textarea name="contenido" class="form-control" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Publicar comentario</button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-warning mt-4">
        Debes iniciar sesión para comentar.
    </div>
    @endauth
</div>
@endsection
