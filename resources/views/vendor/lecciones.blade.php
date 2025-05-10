<h2>Lecciones</h2>
<ul>
@foreach($lecciones as $leccion)
    <li>{{ $leccion->titulo }} - {{ $leccion->descripcion }}</li>
@endforeach
</ul>
