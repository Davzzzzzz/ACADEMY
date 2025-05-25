<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado de Finalización</title>
    <style>
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #f4f6fa;
            margin: 0;
            padding: 0;
        }
        .certificado-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 50px 60px;
            background: #fff;
            border: 8px double #0A74DA;
            box-shadow: 0 8px 32px rgba(0,0,0,0.14);
            border-radius: 18px;
            position: relative;
        }
        .header-logo {
            width: 90px;
            margin-bottom: 18px;
        }
        .titulo-certificado {
            color: #0A74DA;
            font-size: 42px;
            font-family: 'Georgia', serif;
            font-weight: bold;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
        }
        .subtitulo {
            font-size: 24px;
            color: #222;
            margin: 10px 0 24px 0;
        }
        .usuario {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin: 12px 0;
        }
        .detalle {
            font-size: 21px;
            margin: 10px 0 22px 0;
            color: #444;
        }
        .curso {
            font-size: 26px;
            color: #0A74DA;
            font-weight: bold;
            margin-bottom: 24px;
        }
        .fecha {
            color: #666;
            margin: 18px 0 0 0;
            font-size: 17px;
        }
        .firma-area {
            margin-top: 60px;
            text-align: right;
        }
        .firma {
            font-family: 'Brush Script MT', cursive;
            font-size: 32px;
            color: #0A74DA;
            margin-bottom: 0;
        }
        .cargo {
            font-size: 17px;
            color: #333;
        }
        .sello-digital {
            position: absolute;
            left: 40px;
            bottom: 60px;
            width: 110px;
            opacity: 0.18;
        }
        .numero-certificado {
            position: absolute;
            right: 40px;
            bottom: 36px;
            font-size: 14px;
            color: #aaa;
        }
        /* Opcional QR */
        .qr {
            position: absolute;
            left: 40px;
            top: 40px;
            width: 72px;
        }
    </style>
</head>
<body>
    <div class="certificado-container">
        {{-- Logo opcional --}}
        <!-- <img src="{{ asset('img/logo.png') }}" class="header-logo" alt="Logo"> -->

        <div class="titulo-certificado">CERTIFICADO</div>
        <div class="subtitulo">de finalización</div>
        <div class="detalle">Se deja constancia que</div>
        <div class="usuario">{{ $usuario->nombre }}</div>
        <div class="detalle">ha completado satisfactoriamente el programa de estudios de</div>
        <div class="curso">Academy Hands</div>
        <div class="detalle">Demostrando dedicación y compromiso en todas las lecciones.</div>
        <div class="fecha">Fecha de emisión: {{ date('d/m/Y') }}</div>

        <div class="firma-area">
            <div class="firma">David D. Director</div>
            <div class="cargo">Director General<br>Academy Hands</div>
        </div>

        <!-- Sello digital simulado -->
        <img src="https://i.imgur.com/7QxI2aU.png" class="sello-digital" alt="Sello Digital">

        <!-- Número de certificado -->
        <div class="numero-certificado">Certificado Nº: {{ $numero ?? 'AH-' . strtoupper(substr(md5($usuario->nombre . date('dmy')), 0, 8)) }}</div>
    </div>
</body>
</html>
