@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Botón volver al inicio -->
    <div class="mb-3">
        <a href="{{ route('inicio') }}" class="btn btn-secondary">
            <i class="bi bi-house"></i> Volver al inicio
        </a>
    </div>

    <h2 class="mb-4">Foros disponibles</h2>
    <div class="mb-3">
        <a href="{{ route('foros.create') }}" class="btn btn-primary">Crear nuevo foro</a>
    </div>

    @if ($foros->count())
        @foreach ($foros as $foro)
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('foros.show', $foro->id) }}">
                            {{ $foro->titulo }}
                        </a>
                    </h4>
                    <p class="card-text">{{ $foro->descripcion }}</p>
                    <small class="text-muted">
                        Creado el: {{ $foro->fecha_creacion }} |
                        Comentarios: {{ $foro->comentarios_count ?? 0 }}
                    </small>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No hay foros disponibles.
        </div>
    @endif
</div>
@endsection
