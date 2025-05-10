<div class="card mb-2 ms-{{ $publicacion->parent_id ? '4' : '0' }}">
    <div class="card-body">
        <p>{{ $publicacion->contenido }}</p>
        <small>Por {{ $publicacion->usuario->nombre }}</small>

        {{-- Formulario de respuesta --}}
        <form method="POST" action="{{ route('publicaciones.store') }}">
            @csrf
            <input type="hidden" name="foro_id" value="{{ $publicacion->foro_id }}">
            <input type="hidden" name="parent_id" value="{{ $publicacion->id }}">
            <textarea name="contenido" class="form-control my-1" rows="2" required placeholder="Responder..."></textarea>
            <button class="btn btn-sm btn-outline-secondary">Responder</button>
        </form>

        {{-- Respuestas anidadas --}}
        @foreach ($publicacion->respuestas as $respuesta)
            @include('publicaciones._publicacion', ['publicacion' => $respuesta])
        @endforeach
    </div>
</div>
