<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado MAS Bienestar</title>
    <style>
        /* Estilos generales - OPTIMIZADOS PARA PDF */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            margin: 0;
            padding: 0;
            background: white;
            width: 100%;
            height: 100%;
        }
        
        /* Contenedor principal del certificado - HORIZONTAL */
        .certificate-container {
            width: 100%;
            max-width: 1100px;
            height: 650px;
            padding: 40px;
            margin: 0 auto;
            border: 12px solid #0079A7;
            background-color: #ffffff;
            background-image:
                radial-gradient(circle at 40% 50%, rgba(75, 185, 231, 0.35) 0%, rgba(255, 255, 255, 0.8) 60%),
                radial-gradient(circle at 80% 50%, rgba(0, 121, 167, 0.35) 0%, rgba(255, 255, 255, 0.8) 60%),
                linear-gradient(to right, #e3f5fb 0%, #b6e2f0 50%, #e3f5fb 100%);
            background-blend-mode: overlay, lighten, normal;
            text-align: center;
            position: relative;
            overflow: hidden;

            /* Efecto de borde elegante */
            outline: 4px solid rgba(0, 121, 167, 0.5);
            outline-offset: 8px;

            /* Fuerza colores en PDF */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }


        
        /* Encabezado institucional - MODIFICADO: Un solo logo a la izquierda */
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 3;
        }
        
        .logo-left {
           
            height: 100px;
            display: flex;
            margin-right:  5px
            flex-direction: column;
            align-items: center;
            justify-content: center;
            
        }
        
        .logo-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0079A7, #4BB9E7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            line-height: 1.2;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .institution-title {
           
            padding: 0 20px;
        }
        
        .institution-title h1 {
            font-size: 22px;
            color: #0079A7;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .institution-title h2 {
            font-size: 18px;
            color: #2C9EC4;
            font-weight: normal;
            margin-bottom: 5px;
        }
        
        .institution-title h3 {
            font-size: 16px;
            color: #343A40;
            font-weight: normal;
        }
        
        /* Cellos decorativos - AJUSTADOS */
        .cello {
            position: absolute;
            width: 120px;
            height: 120px;
            opacity: 0.8;
            z-index: 1;
        }
        
        .cello-top-left {
            top: 20px;
            left: 20px;
            border-top: 12px solid #0079A7;
            border-left: 12px solid #0079A7;
        }
        
        .cello-top-right {
            top: 20px;
            right: 20px;
            border-top: 12px solid #4BB9E7;
            border-right: 12px solid #4BB9E7;
        }
        
        .cello-bottom-left {
            bottom: 20px;
            left: 20px;
            border-bottom: 12px solid #4BB9E7;
            border-left: 12px solid #4BB9E7;
        }
        
        .cello-bottom-right {
            bottom: 20px;
            right: 20px;
            border-bottom: 12px solid #0079A7;
            border-right: 12px solid #0079A7;
        }
        
        /* Líneas decorativas - MEJORADAS */
        .decorative-line {
            position: absolute;
            width: 3px;
            background: linear-gradient(to bottom, transparent, #0079A7, #4BB9E7, #0079A7, transparent);
            height: 85%;
            top: 7.5%;
        }
        
        .line-left {
            left: 160px;
        }
        
        .line-right {
            right: 160px;
        }
        
        /* Marca de agua - AJUSTADA */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            opacity: 0.05;
            color: #0079A7;
            z-index: 0;
            white-space: nowrap;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        /* Sellos oficiales - REUBICADOS Y MEJORADOS */
        .stamp {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px dashed #0079A7;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .stamp-left {
            top: 60px;
            left: 60px;
        }
        
        .stamp-right {
            top: 60px;
            right: 60px;
        }
        
        .stamp-text {
            font-size: 10px;
            font-weight: bold;
            color: #0079A7;
            text-align: center;
            transform: rotate(-15deg);
            line-height: 1.3;
        }
        
        /* Contenido principal - MEJORADO */
        .certificate-content {
            position: relative;
            z-index: 2;
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 60%;
            padding: 0 40px;
        }
        
        .certificate-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #0079A7;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }
        
        .certificate-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 25%;
            width: 50%;
            height: 2px;
            background: linear-gradient(to right, transparent, #4BB9E7, transparent);
        }
        
        .user-name {
            font-size: 24px;
            margin: 20px 0;
            color: #343A40;
            border-bottom: 2px solid #4BB9E7;
            display: inline-block;
            padding-bottom: 8px;
            font-weight: bold;
        }
        
        .module-name {
            font-size: 20px;
            color: #0079A7;
            font-style: italic;
        }
        
        .certificate-text {
            font-size: 16px;
            line-height: 1.5;
            color: #343A40;
        }
        
        .date-text {
            font-size: 14px;
            margin: 15px 0;
            color: #6C757D;
        }
        
        /* Firmas - MEJORADAS */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            position: relative;
            z-index: 2;
            padding: 0 40px;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            width: 80%;
            height: 1px;
            background-color: #343A40;
            margin: 20px auto 10px;
        }
        
        .signature-text {
            font-size: 12px;
            margin-top: 5px;
            color: #343A40;
        }
        
        /* Patrón de fondo */
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 15% 30%, rgba(0, 121, 167, 0.05) 5%, transparent 15%),
                radial-gradient(circle at 85% 70%, rgba(75, 185, 231, 0.05) 5%, transparent 15%);
            background-size: 120px 120px;
            z-index: 0;
        }
        
        /* Código de validación */
        .validation-code {
            position: absolute;
            bottom: 0px;
            right: 20px;
            font-size: 10px;
            color: #6C757D;
            z-index: 2;
        }
        
        /* Elementos decorativos adicionales */
        .corner-ornament {
            position: absolute;
            width: 60px;
            height: 60px;
            z-index: 1;
        }
        
        .corner-top-left {
            top: 30px;
            left: 30px;
            border-top: 8px solid #4BB9E7;
            border-left: 8px solid #4BB9E7;
        }
        
        .corner-top-right {
            top: 30px;
            right: 30px;
            border-top: 8px solid #2C9EC4;
            border-right: 8px solid #2C9EC4;
        }
        
        .corner-bottom-left {
            bottom: 30px;
            left: 30px;
            border-bottom: 8px solid #2C9EC4;
            border-left: 8px solid #2C9EC4;
        }
        
        .corner-bottom-right {
            bottom: 30px;
            right: 30px;
            border-bottom: 8px solid #4BB9E7;
            border-right: 8px solid #4BB9E7;
        }
        
        /* Efecto de sello húmedo */
        .wet-stamp {
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(75, 185, 231, 0.1) 0%, transparent 70%);
            z-index: 1;
        }
        
        .wet-stamp-left {
            top: 40px;
            left: 40px;
        }
        
        .wet-stamp-right {
            top: 40px;
            right: 40px;
        }

        /* Estilos específicos para impresión/PDF */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
                width: 100%;
                height: 100%;
            }
            
            .certificate-container {
                box-shadow: none;
                margin: 0;
                padding: 25px;
                border: 15px solid #0079A7;
                width: 100%;
                height: 100%;
                page-break-inside: avoid;
            }
            
            /* Asegurar que los gradientes se rendericen */
            .logo-circle {
                background: #0079A7; /* Fallback sólido */
                background: linear-gradient(135deg, #0079A7, #4BB9E7);
            }
        }
        
        /* Reglas específicas para Browsershot/PDF */
        @page {
            margin: 0;
            size: landscape;
        }
    </style>
</head>
<body>
    <div class="certificate-container">

        <!-- Encabezado institucional - MODIFICADO: Solo un logo a la izquierda -->
        <div class="header">
            <div class="logo-left">
                <div class="logo-circle">
                    <!-- Imagen de logo - reemplazar con la ruta correcta -->
                    <div style="width:100%;height:100%;background:#fff;display:flex;align-items:center;justify-content:center;color:#0079A7;font-size:10px;">
                        @if (isset($logo_left))
                            <img src="data:image/png;base64,{{ $logo_left }}" alt ="Logo norte" width = "120" style="margin-top: 10px">
                        @else
                            <img src="{{ asset('images/logos/Logo_entorno.jpg') }}" alt="">
                        @endif
                    </div>
                </div>
            </div>
            <div class="institution-title">
                <h1>MAS Bienestar</h1>
                <h2>Secretaria distrital de salud</h2>
                <h2>Subred Norte</h2>
            </div>
        </div>
        
        <!-- Marca de agua -->
        <div class="watermark">Salud Pública</div>

        <!-- Patrón de fondo -->
        <div class="background-pattern"></div>
        
        <!-- Sellos húmedos -->
        <div class="wet-stamp wet-stamp-left"></div>
        <div class="wet-stamp wet-stamp-right"></div>
        
        <!-- Elementos decorativos de esquina -->
        <div class="corner-ornament corner-top-left"></div>
        <div class="corner-ornament corner-top-right"></div>
        <div class="corner-ornament corner-bottom-left"></div>
        <div class="corner-ornament corner-bottom-right"></div>
        
        <!-- Contenido del certificado -->
        <div class="certificate-content">
            <h1 class="certificate-title">Certificado de Participación</h1>
            <p class="certificate-text">La Secretaría Distrital de Salud de Bogotá, Subred Norte de Servicios de Salud</p>
            <p class="certificate-text">otorga el presente certificado a:</p>
            <h2 class="user-name">
                @if (isset($name))
                   {{ $name }}
                @else
                    {{ Auth::user()->name }}
                @endif</h2>
            <p class="certificate-text">Por haber completado satisfactoriamente todos los módulos del</p>
            <h3 class="module-name">Programa Mas Bienestar</h3>
            <p class="certificate-text">en reconocimiento a su dedicación y compromiso.</p>
            <p class="date-text">Fecha de expedición: 
                @if (isset($date))
                    {{ $date }}
                @else
                    {{ date('d/m/y') }}
                @endif

                Bogotá D.C.
            </p>
        </div>
        
        <!-- Firmas -->
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line"></div>
                <p class="signature-text">Dr. Carlos Andrés Martínez</p>
                <p class="signature-text">Director General - Subred Norte</p>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <p class="signature-text">Dra. María Fernanda López</p>
                <p class="signature-text">Coordinadora de Formación</p>
            </div>
        </div>
        
        <!-- Código de validación -->
        <div class="validation-code">
            @if (isset($verification_code))
                Código de validación: {{ $verification_code }}
                
            @else
                Código de validación: SS-BOG-SN-XXXX-2025
                
            @endif
            
        </div>
    </div>
</body>
</html>