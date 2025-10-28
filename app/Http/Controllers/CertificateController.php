<?php

namespace App\Http\Controllers;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    public function download()
    {
        $user = Auth::user();
        $event = 'Curso de Inducción Subred Norte';
        $date = date('Y-m-d');

        // Generar un código de verificación único
        $verificationCode = 'SUBRED-' . strtoupper(Str::random(8));

        // Cargar y convertir el logo a base64
        $imagePath = public_path('images/logos/Logo_entorno.jpg');
        $base64Image = base64_encode(file_get_contents($imagePath));

        $data = [
            'name' => $user->name,
            'event' => $event,
            'date' => date('d/m/Y', strtotime($date)),
            'logo_left' => $base64Image,
            'verification_code' => $verificationCode,
        ];

        $htmlContent = view('components.certificate', $data)->render();

        // Definir ruta de guardado
        $folderPath = storage_path('app/public/certificados/' . $user->id);
        $pdfFileName = 'certificado_' . $user->id . '.pdf';
        $fullPath = $folderPath . '/' . $pdfFileName;

        // Crear carpeta si no existe
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Generar el PDF
        Browsershot::html($htmlContent)
            ->paperSize(900, 663, 'px')
            ->save($fullPath);

        // Guardar registro en la base de datos
        Certificate::create([
            'user_id' => $user->id,
            'file_path' => 'certificados/' . $user->id . '/' . $pdfFileName,
            'verification_code' => $verificationCode,
            'event' => $event,
            'date' => $date,
        ]);

        // Descargar el archivo
        return response()->download($fullPath);
    }

    // Validar un certificado por código
    public function verify($code)
    {
        $certificate = Certificate::where('verification_code', $code)->first();

        if (!$certificate) {
            return response()->json(['valid' => false, 'message' => 'Certificado no encontrado']);
        }

        return response()->json([
            'valid' => true,
            'user' => $certificate->user->name,
            'event' => $certificate->event,
            'date' => $certificate->date,
        ]);
    }
}
