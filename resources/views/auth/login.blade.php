@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<div class="content-principal">

    <div class="imagen-side">
        <img src="{{ asset('images/backgrounds/imagen_entorno.jpg') }}" alt="Logo Secretaría de Salud" class="logo-side">
        <div class="fondo-content">
            <h2>Sistema de Gestión de Salud</h2>
            <p>Acceda de forma segura al sistema integral de gestión de información de salud.</p>
        </div>
    </div>


    <div class="login-panel">
        <div class="login-header">
            <h1>Sistema de Acceso</h1>
            <p>Ingrese sus credenciales para continuar</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <div class="input-icon"><i class="fas fa-user"></i></div>
                <input id="email" type="email" class="form-control" name="email" placeholder="usuario@ejemplo.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-icon"><i class="fas fa-key"></i></div>
                <input id="password" type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login pulse">Ingresar al Sistema</button>
            
            <div class="login-footer">
                <a class="forgot-password" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
                
                <div class="register-link">
                    ¿No tienes una cuenta? <a href="{{ route('register') }}">Registrarse</a>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection