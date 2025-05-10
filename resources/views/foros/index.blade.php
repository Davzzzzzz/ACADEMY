@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Foros de la Comunidad</h3>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('foros.create') }}" class="btn btn-success">+ Nuevo Foro</a>
    </div>
    <a href="{{ route('inicio') }}" class="btn btn-secondary mb-3">← Volver al Inicio</a>
    @foreach ($foros as $foro)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $foro->titulo }}</h5>
                <p class="card-text">{{ $foro->contenido }}</p>
                <small class="text-muted">Publicado por {{ $foro->usuario->nombre ?? 'Anónimo' }} hace {{ $foro->created_at->diffForHumans() }}</small>

                <div class="mt-2">
                    <a href="{{ route('foros.show', $foro->id) }}" class="btn btn-sm btn-outline-secondary">Ver</a>

                    @if (auth()->id() === $foro->usuario_id)
                        <a href="{{ route('foros.edit', $foro->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
