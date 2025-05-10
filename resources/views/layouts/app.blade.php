<!-- aca va la parte de arriba  -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Academy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: hsla(0, 0%, 100%, 0.549);
            font-family: sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(12, 203, 44, 0.588);
        }
    </style>
</head>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<body>

    {{-- Navbar simple con fondo verde --}}
    <nav class="navbar navbar-light bg-success">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="navbar-brand mb-0 h1 text-white">
                "Educar es aprender a escuchar, incluso cuando el lenguaje no tiene sonido."
            </span>
            <a href="{{ url('/api/documentation#/') }}" class="btn btn-primary">CRUD</a>
        </div>
    </nav>

    {{-- Contenido --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Vue y scripts de cada vista --}}
    @yield('scripts')

</body>
</html>
