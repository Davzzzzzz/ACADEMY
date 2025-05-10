@extends('layouts.app')

@section('content')
{{-- Encabezado superior --}}
<div class="container mt-3 d-flex justify-content-between align-items-center">
    <h2 class="mb-0">Academy Hands 🧏</h2>

    <div>
        <a href="{{ route('foros.index') }}" class="btn btn-sm btn-outline-secondary me-2">Foros</a>

        @auth
            <span class="me-2">Bienvenido a tu cuenta, {{ Auth::user()->nombre }} 👋</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Cerrar sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Iniciar sesión</a>
        @endauth
    </div>
</div>

{{-- Contenido principal --}}
<div class="container mt-5 d-flex">
    {{-- Parte izquierda: tarjetas en forma de camino diagonal --}}
    <div class="w-75">
        <h3>Contenido Básico</h3>
        <div class="diagonal-container position-relative" style="width: 100%; min-height: 700px;">
            @php
                $cardWidth = 180;
                $cardHeight = 140;
                $gapX = 60; // Espacio horizontal entre tarjetas
                $gapY = 80; // Espacio vertical entre tarjetas

                $x = 0;
                $y = 0;
                $direction = 1; // 1 = ↘️, -1 = ↙️
            @endphp

            @foreach ($lecciones as $index => $leccion)
                @php
                    $left = $x;
                    $top = $y;

                    // Alternamos dirección
                    if ($direction === 1) {
                        $x += $cardWidth + $gapX;
                        $y += $gapY;
                        $direction = -1;
                    } else {
                        $x -= $cardWidth + $gapX;
                        $y += $gapY;
                        $direction = 1;
                    }
                @endphp

                <div class="card position-absolute p-2 diagonal-card"
                     style="left: {{ $left }}px; top: {{ $top }}px; width: {{ $cardWidth }}px; height: {{ $cardHeight }}px;">
                    <div class="card-body text-center">
                        <h6 class="card-title">{{ $leccion->titulo }}</h6>
                        <p class="card-text">{{ $leccion->descripcion }}</p>
                        <a href="{{ route('lecciones.ejercicios', $leccion->id_leccion) }}" class="btn btn-sm btn-primary">Revisar</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Parte derecha: progreso --}}
    <div class="w-25 text-center">
        <div class="card">
            <div class="card-body">
                <h5>Progreso</h5>
                <svg width="100" height="100">
                    <circle cx="50" cy="50" r="45" stroke="#eee" stroke-width="10" fill="none" />
                    <circle cx="50" cy="50" r="45" stroke="#28a745" stroke-width="10" fill="none"
                            stroke-dasharray="282.6"
                            stroke-dashoffset="{{ 282.6 - (282.6 * $progreso / 100) }}"
                            transform="rotate(-90 50 50)" />
                    <text x="50%" y="50%" text-anchor="middle" dy=".3em">{{ $progreso }}%</text>
                </svg>
                <button class="btn btn-success mt-2">Fortalecer</button>
            </div>
        </div>
    </div>
</div>

{{-- Estilos --}}
<style>
    .diagonal-container {
        position: relative;
        padding: 30px;
        overflow-x: auto;
        overflow-y: auto;
        min-height: 600px;
    }

    .diagonal-card {
        transition: transform 0.2s ease;
    }

    .diagonal-card:hover {
        transform: scale(1.05);
        z-index: 10;
    }
</style>
@endsection
