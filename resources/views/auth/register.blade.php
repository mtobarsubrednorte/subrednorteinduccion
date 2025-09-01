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

    .register-container {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .register-box {
        background-color: rgba(0, 0, 0, 0.85);
        padding: 40px;
        border-radius: 12px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.5);
        color: #fff;
        text-align: center;
    }

    .register-box img.logo {
        max-width: 120px;
        margin-bottom: 20px;
        filter: drop-shadow(0 2px 6px rgba(0,0,0,0.6));
    }

    .register-box h2 {
        margin-bottom: 25px;
        font-size: 26px;
        font-weight: bold;
    }

    .register-box input,
    .register-box select {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        background-color: #333;
        color: #fff;
    }

    .register-box input:focus,
    .register-box select:focus {
        outline: none;
        box-shadow: 0 0 5px #1E90FF;
    }

    .register-box button {
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

    .register-box button:hover {
        background-color: #0b65c2;
    }

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
        .register-box {
            padding: 30px 20px;
        }
        .top-buttons {
            flex-direction: column;
            right: 20px;
            top: 15px;
        }
    }
</style>

<!-- Botones Login/Register -->
<div class="top-buttons">
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
</div>

<div class="register-container">
    <div class="register-box">
        <img src="{{ asset('images/Logo_entorno.jpg') }}" alt="Logo" class="logo">

        <h2>Registro</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input id="name" type="text" name="name" placeholder="Nombre completo" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <input id="email" type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
            @error('email')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <input id="document_number" type="text" name="document_number" placeholder="Número de documento" value="{{ old('document_number') }}" required>
            @error('document_number')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <select id="document_type" name="document_type" required>
                <option value="">Seleccione tipo de documento</option>
                <option value="CC">Cédula de ciudadanía</option>
                <option value="TI">Tarjeta de identidad</option>
                <option value="CE">Cédula de extranjería</option>
                <option value="PAS">Pasaporte</option>
            </select>
            @error('document_type')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <select id="profile_id" name="profile_id" required>
                <option value="">Seleccione perfil</option>
                <option value="1">Gestor</option>
                <option value="2">Psicólogo</option>
                <option value="3 Clínico">Psicólogo Clínico</option>
                <option value="4">Médico</option>
                <option value="5">Enfermero</option>
                <option value="6">Nutricionista</option>
                <option value="7">Ingeniero</option>
            </select>
            @error('profile_id')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <select id="gender" name="gender" required>
                <option value="">Seleccione sexo</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
            @error('gender')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <select id="subred" name="subred" required>
                <option value="">Seleccione subred</option>
                <option value="NORTE">NORTE</option>
                <option value="SUR">SUR</option>
                <option value="SUR OCCIDENTE">SUR OCCIDENTE</option>
                <option value="CENTRO ORIENTE">CENTRO ORIENTE</option>
            </select>
            @error('subred')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <input id="password" type="password" name="password" placeholder="Contraseña" required>
            @error('password')
                <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror

            <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</div>
@endsection
