<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;

use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download()
    {
        $user = Auth::user();

        $imagePath = '../public/images/logos/Logo_entorno.jpg';
        $imageContents = file_get_contents($imagePath);
        $base64Image = base64_encode($imageContents);

        $data = [
            'name' => $user->name,
            'event' => 'Curso de Inducción Subred Norte',
            'date' => date('d/m/Y'),
            'logo_left' => $base64Image,
        ];

        $htmlContent = view('components.certificate', $data)->render();

        Browsershot::html($htmlContent)
            ->paperSize(900, 663, 'px') // Tamaño carta horizontal en píxeles
            ->save(storage_path('app/public/certificado_'.$user->name.'.pdf'));
        

        // Descargar el archivo PDF generado
        return response()->download(storage_path('app/public/certificado_'.$user->name.'.pdf'));
    }
}