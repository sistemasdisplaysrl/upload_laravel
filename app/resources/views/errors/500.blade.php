<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error del Sistema</title>
    
    
    <link rel="shortcut icon" href="{{ asset('/assets/compiled/png/logo_display.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/compiled/css/error.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="error">
        

<div class="error-page container">
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('/assets/compiled/svg/error-500.svg') }}" alt="Not Found">
            <h1 class="error-title">Error del Sistema</h1>
            <p class="fs-5 text-gray-600">El sitio web actualmente no está disponible. Inténtelo de nuevo más tarde o
                contacte al desarrollador.</p>
            <a href="{{ route('admin.manuales.index') }}" class="btn btn-lg btn-outline-primary mt-3">Volver</a>
        </div>
    </div>
</div>


    </div>
</body>

</html>