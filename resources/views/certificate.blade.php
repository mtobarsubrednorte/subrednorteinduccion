<html>
  <body style="text-align:center; font-family:sans-serif;">
    <h1>Certificado de Inducción</h1>
    <p>Se certifica que</p>
    <h2>{{ $user->name }}</h2>
    <p>ha completado satisfactoriamente el programa de inducción de Subrednorte.</p>
    <p>Fecha: {{ now()->format('d/m/Y') }}</p>
  </body>
</html>