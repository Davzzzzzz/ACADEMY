@extends('layouts.app')

@section('content')

{{-- Encabezado superior --}}
<div class="container mt-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
    <h2 class="mb-2 mb-md-0">Academy Hands 🧏</h2>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <a href="{{ route('foros.index') }}" class="btn btn-sm btn-outline-secondary">Foros</a>

        @auth
            {{-- Mostrar botón Dashboard solo a administradores --}}
            @if (Auth::user()->id_rol == 2)
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-dark">Dashboard</a>
            @endif

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
<div class="container mt-5 d-flex flex-column flex-lg-row gap-4">

    {{-- Parte izquierda: tarjetas en forma de camino diagonal --}}
    <div class="col-12 col-lg-9 position-relative">
        <h3>Contenido Básico</h3>
        <div class="diagonal-container position-relative" style="width: 100%; min-height: 700px; overflow-x: auto; overflow-y: auto;">

            @php
                $cardWidth = 180;
                $cardHeight = 140;
                $gapX = 60;
                $gapY = 80;
                $x = 0;
                $y = 0;
                $direction = 1;
            @endphp

            @foreach ($lecciones as $index => $leccion)
                @php
                    $left = $x;
                    $top = $y;

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

    {{-- Parte derecha: progreso, certificado y racha --}}
    <div class="col-12 col-lg-3 text-center">

        {{-- Progreso --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Progreso</h5>
                <svg class="mx-auto" width="100" height="100">
                    <circle cx="50" cy="50" r="45" stroke="#eee" stroke-width="10" fill="none" />
                    <circle cx="50" cy="50" r="45" stroke="#28a745" stroke-width="10" fill="none"
                            stroke-dasharray="282.6"
                            stroke-dashoffset="{{ 282.6 - (282.6 * $progreso / 100) }}"
                            transform="rotate(-90 50 50)" />
                    <text x="50%" y="50%" text-anchor="middle" dy=".3em">{{ $progreso }}%</text>
                </svg>
                <button class="btn btn-success mt-2 w-100 w-md-auto">Fortalecer</button>
            </div>
        </div>

        {{-- Certificado --}}
        @if ($progreso == 100)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>🎉 ¡Certificado!</h5>
                    <p class="text-muted">Has completado todas las lecciones.</p>
                    <a href="{{ route('certificado.generar') }}" class="btn btn-primary w-100 w-md-auto">Descargar certificado</a>
                </div>
            </div>
        @endif

        {{-- Racha --}}
        <div class="card">
            <div class="card-body">
                <h5>🔥 Racha</h5>
                <p class="fs-3">{{ $racha }} días</p>
                <p class="text-muted">¡Sigue así!</p>
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

    /* Ajustes para móviles */
    @media (max-width: 768px) {
        .diagonal-card {
            width: 140px !important;
            height: 120px !important;
            font-size: 0.85rem;
        }
    }
</style>

@endsection
