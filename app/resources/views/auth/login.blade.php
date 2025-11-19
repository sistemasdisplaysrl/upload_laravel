<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manual Management</title>
    
    
    
    <link rel="shortcut icon" href="{{ asset('/assets/compiled/png/logo_display.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/compiled/css/auth.css') }}">
    <style>
        .auth-logo {
            text-align: center;
            margin-bottom: 1.5rem !important;
        }

        .auth-logo .logo-login {
            width: 180px !important;
            height: 180px !important;
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('login') }}">
                            @php
                                $ajuste = $ajustes ?? \App\Models\Ajuste::first();
                            @endphp
                            @if($ajuste && $ajustes->logo)
                                <img src="{{ asset('storage/'.$ajustes->logo) }}" alt="Logo" class="logo-login">
                            @else
                                <img src="{{ asset('/assets/compiled/png/logo_display.png') }}" alt="Logo">
                            @endif
                        </a>
                    </div>
                    <h1 class="auth-title">
                        {{ $ajuste->nombre ?? 'Display' }}
                    </h1>
                    <p class="auth-subtitle mb-5">Ingrese sus credenciales para iniciar sesión.</p>

                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Iniciar sesión</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"
                @if($ajustes && $ajustes->imagen_login)
                    style="background-image: url('{{ asset('storage/'.$ajustes->imagen_login) }}');
                            background-size: cover;
                            background-position: center;"
                @endif
                ></div>
            </div>
        </div>
    </div>
</body>

</html>