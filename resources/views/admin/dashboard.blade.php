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
    <h1 class="mb-4">Panel de Canva Administración</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tarjetas resumen --}}
  <div class="row">
   {{-- Usuarios (Azul fuerte) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #fbff00; color: white;">
        <div class="card-body">
            <h5 class="card-title">Usuarios</h5>
            <p class="card-text display-6">{{ $usuarios->count() }}</p>
        </div>
    </div>
</div>

{{-- Foros (Gris oscuro como neutro) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #e12d1d; color: white;">
        <div class="card-body">
            <h5 class="card-title">Foros</h5>
            <p class="card-text display-6">{{ $foros->count() }}</p>
        </div>
    </div>
</div>

{{-- Comentarios (Amarillo bandera) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #f1f50e; color: white;">
        <div class="card-body">
            <h5 class="card-title">Comentarios</h5>
            <p class="card-text display-6">{{ $comentarios->count() }}</p>
        </div>
    </div>
</div>

{{-- Reportes (Rojo bandera) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #00b7ff; color: white;">
        <div class="card-body">
            <h5 class="card-title">Reportes</h5>
            <p class="card-text display-6">{{ $reportes->count() }}</p>
        </div>
    </div>
</div>

{{-- Progresos (Azul claro complementario) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #00b7ff; color: white;">
        <div class="card-body">
            <h5 class="card-title">Progresos</h5>
            <p class="card-text display-6">{{ $progresos->count() }}</p>
        </div>
    </div>
</div>

{{-- Rachas (Amarillo oscuro) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #00b7ff; color: white;">
        <div class="card-body">
            <h5 class="card-title">Rachas</h5>
            <p class="card-text display-6">{{ $rachas->count() }}</p>
        </div>
    </div>
</div>

{{-- Ejercicios (Azul medio) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #f80000; color: white;">
        <div class="card-body">
            <h5 class="card-title">Ejercicios</h5>
            <p class="card-text display-6">{{ $ejercicios->count() }}</p>
        </div>
    </div>
</div>

{{-- Lecciones (Rojo claro) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color:  #f1f50e; color: white;">
        <div class="card-body">
            <h5 class="card-title">Lecciones</h5>
            <p class="card-text display-6">{{ $lecciones->count() }}</p>
        </div>
    </div>
</div>

{{-- Niveles (Verde complementario) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: #e12d1d; color: white;">
        <div class="card-body">
            <h5 class="card-title">Niveles</h5>
            <p class="card-text display-6">{{ $niveles->count() }}</p>
        </div>
    </div>
</div>

{{-- Roles (Negro elegante) --}}
<div class="col-md-4 mb-3">
    <div class="card border-0 shadow-sm" style="background-color: rgba(12, 203, 44, 0.588); color: white;">
        <div class="card-body">
            <h5 class="card-title">Roles</h5>
            <p class="card-text display-6">{{ $roles->count() }}</p>
        </div>
    </div>
</div>



@endsection
