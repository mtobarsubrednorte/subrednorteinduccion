@extends('layouts.app')

@section('content')
<style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .content-principal {
            display: flex;
            width: 1000px;
            max-width: 100%;
            height: auto;
            min-height: 600px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .imagen-side {
            flex: 1;
            background: linear-gradient(135deg, #1e88e5, #0d47a1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: white;
        }
        
        .logo-side {
            position: absolute;
            top: 30px;
            left: 30px;
            width: 85%;
            height: auto;
        }
        
        .fondo-content {
            z-index: 2;
        }
        
        .fondo-content h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .fondo-content p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        .register-panel {
            flex: 1.2;
            padding: 40px 30px;
            overflow-y: auto;
            max-height: 600px;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header h1 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .register-header p {
            color: #7f8c8d;
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }
        
        .input-icon {
            position: absolute;
            top: 38px;
            left: 15px;
            color: #7f8c8d;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        
        .btn-register {
            background: #3498db;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .register-footer {
            margin-top: 25px;
            text-align: center;
        }
        
        .login-link {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .login-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        @media (max-width: 900px) {
            .content-principal {
                flex-direction: column;
                height: auto;
            }
            
            .imagen-side {
                min-height: 200px;
                padding: 20px;
            }
            
            .register-panel {
                padding: 30px 20px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
        
        @media (max-width: 480px) {
            .register-panel {
                padding: 20px 15px;
            }
        }
</style>

<body>
    <div class="content-principal">
        <div class="imagen-side">
            <img src="{{ asset('images/backgrounds/imagen_entorno.jpg') }}" alt="Logo Secretaría de Salud" class="logo-side">
            <div class="fondo-content">
                <h2>Sistema de Gestión de Salud</h2>
                <p>Registro de nuevo usuario en el sistema integral de gestión de información de salud.</p>
            </div>
        </div>

        <div class="register-panel">
            <div class="register-header">
                <h1>Crear Cuenta</h1>
                <p>Complete el formulario para registrarse</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <div class="input-icon"><i class="fas fa-user"></i></div>
                    <input id="name" type="text" name="name" placeholder="Ingrese su nombre completo" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <div class="input-icon"><i class="fas fa-envelope"></i></div>
                    <input id="email" type="email" name="email" placeholder="usuario@ejemplo.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="document_type">Tipo de documento</label>
                        <div class="input-icon"><i class="fas fa-id-card"></i></div>
                        <select id="document_type" name="document_type" required>
                            <option value="">Seleccione tipo</option>
                            <option value="CC" {{ old('document_type') == 'CC' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                            <option value="TI" {{ old('document_type') == 'TI' ? 'selected' : '' }}>Tarjeta de identidad</option>
                            <option value="CE" {{ old('document_type') == 'CE' ? 'selected' : '' }}>Cédula de extranjería</option>
                            <option value="PAS" {{ old('document_type') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                        </select>
                        @error('document_type')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="document_number">Número de documento</label>
                        <div class="input-icon"><i class="fas fa-hashtag"></i></div>
                        <input id="document_number" type="text" name="document_number" placeholder="Número de documento" value="{{ old('document_number') }}" required>
                        @error('document_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="profile_id">Perfil de usuario</label>
                        <div class="input-icon"><i class="fas fa-user-tag"></i></div>
                        <select id="profile_id" name="profile_id" required>
                            <option value="">Seleccione perfil</option>
                            <option value="1" {{ old('profile_id') == '1' ? 'selected' : '' }}>Gestor</option>
                            <option value="2" {{ old('profile_id') == '2' ? 'selected' : '' }}>Psicólogo</option>
                            <option value="3" {{ old('profile_id') == '3' ? 'selected' : '' }}>Psicólogo Clínico</option>
                            <option value="4" {{ old('profile_id') == '4' ? 'selected' : '' }}>Médico</option>
                            <option value="5" {{ old('profile_id') == '5' ? 'selected' : '' }}>Enfermero</option>
                            <option value="6" {{ old('profile_id') == '6' ? 'selected' : '' }}>Nutricionista</option>
                            <option value="7" {{ old('profile_id') == '7' ? 'selected' : '' }}>Ingeniero</option>
                        </select>
                        @error('profile_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">Género</label>
                        <div class="input-icon"><i class="fas fa-venus-mars"></i></div>
                        <select id="gender" name="gender" required>
                            <option value="">Seleccione género</option>
                            <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('gender') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('gender')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="subred">Subred</label>
                    <div class="input-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <select id="subred" name="subred" required>
                        <option value="">Seleccione subred</option>
                        <option value="NORTE" {{ old('subred') == 'NORTE' ? 'selected' : '' }}>NORTE</option>
                        <option value="SUR" {{ old('subred') == 'SUR' ? 'selected' : '' }}>SUR</option>
                        <option value="SUR OCCIDENTE" {{ old('subred') == 'SUR OCCIDENTE' ? 'selected' : '' }}>SUR OCCIDENTE</option>
                        <option value="CENTRO ORIENTE" {{ old('subred') == 'CENTRO ORIENTE' ? 'selected' : '' }}>CENTRO ORIENTE</option>
                    </select>
                    @error('subred')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-icon"><i class="fas fa-key"></i></div>
                        <input id="password" type="password" name="password" placeholder="Ingrese su contraseña" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirmar contraseña</label>
                        <div class="input-icon"><i class="fas fa-lock"></i></div>
                        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirme su contraseña" required>
                    </div>
                </div>

                <button type="submit" class="btn-register">Registrarse</button>
                
                <div class="register-footer">
                    <div class="login-link">
                        ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
