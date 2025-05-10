{{-- Formulario para nueva publicación principal --}}
<form method="POST" action="{{ route('publicaciones.store') }}">
    @csrf
    <input type="hidden" name="foro_id" value="{{ $foro->id_foro }}">
    <textarea name="contenido" class="form-control my-2" required placeholder="Escribe tu publicación"></textarea>
    <button class="btn btn-primary">Publicar</button>
</form>

{{-- Mostrar hilos principales --}}
@foreach ($foro->publicaciones()->whereNull('parent_id')->with('respuestas')->get() as $publicacion)
    @include('publicaciones._publicacion', ['publicacion' => $publicacion])
@endforeach
