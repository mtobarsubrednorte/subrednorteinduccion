@extends('layouts.app')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Arial', sans-serif;
        background: url('{{ asset('images/imagen_entorno.jpg') }}') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Difuminado negro */
        z-index: 0;
    }

    /* Contenedor de login */
    .login-container {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .login-box {
        background-color: rgba(0, 0, 0, 0.85);
        padding: 40px;
        border-radius: 12px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.5);
        color: #fff;
        text-align: center;
    }

    .login-box img.logo {
        max-width: 120px;
        margin-bottom: 20px;
        filter: drop-shadow(0 2px 6px rgba(0,0,0,0.6));
    }

    .login-box h2 {
        margin-bottom: 25px;
        font-size: 26px;
        font-weight: bold;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        background-color: #333;
        color: #fff;
    }

    .login-box input:focus {
        outline: none;
        box-shadow: 0 0 5px #1E90FF;
    }

    .login-box button {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        background-color: #1E90FF;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-box button:hover {
        background-color: #0b65c2;
    }

    .login-box .forgot-password {
        display: block;
        text-align: center;
        margin-top: 10px;
        color: #ccc;
        text-decoration: none;
        font-size: 14px;
    }

    .login-box .forgot-password:hover {
        color: #fff;
    }

    /* Contenedor superior de botones Login/Register */
    .top-buttons {
        position: absolute;
        top: 20px;
        right: 30px;
        z-index: 2;
        background: rgba(0,0,0,0.7);
        padding: 10px 20px;
        border-radius: 12px;
        display: flex;
        gap: 10px;
    }

    .top-buttons a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 8px;
        background-color: #1E90FF;
        transition: 0.3s;
    }

    .top-buttons a:hover {
        background-color: #0b65c2;
    }

    @media (max-width: 768px) {
        .login-box {
            padding: 30px 20px;
        }

        .top-buttons {
            flex-direction: column;
            right: 20px;
            top: 15px;
        }
    }
</style>

<!-- Botones Login/Register en la esquina superior derecha -->
<div class="top-buttons">
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
</div>

<div class="login-container">
    <div class="login-box">
        <img src="{{ asset('images/Logo_entorno.jpg') }}" alt="Logo" class="logo">

        <h2>Iniciar Sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <input id="email" type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span style="color:red; font-size:13px;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input id="password" type="password" name="password" placeholder="Contraseña" required>
                @error('password')
                    <span style="color:red; font-size:13px;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Ingresar</button>

            <a class="forgot-password" href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
        </form>
    </div>
</div>
@endsection