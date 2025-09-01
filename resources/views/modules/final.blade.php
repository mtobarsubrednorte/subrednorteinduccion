@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h1 class="mb-4">🎉 ¡Has completado el curso!</h1>
    <p class="lead">Gracias por finalizar todos los módulos. Ahora puedes descargar tu certificado.</p>

    <a href="{{ route('certificate.generate') }}" class="btn btn-warning btn-lg mt-4">
        🎓 Descargar Certificado
    </a>
</div>
@endsection