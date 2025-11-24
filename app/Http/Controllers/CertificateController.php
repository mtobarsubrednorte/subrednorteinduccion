<?php

namespace App\Http\Controllers;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    public function download()
    {
        $user = Auth::user();
        $event = 'Curso de Inducción Subred Norte';
        $date = date('Y-m-d');

        $verificationCode = 'SUBRED-' . strtoupper(Str::random(8));

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

        $folderPath = storage_path('app/public/certificados/' . $user->id);
        $pdfFileName = 'certificado_' . $user->id . '.pdf';
        $fullPath = $folderPath . '/' . $pdfFileName;

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // 🧩 Establece el cache local de Puppeteer para Chrome
        putenv('PUPPETEER_CACHE_DIR=' . env('PUPPETEER_CACHE_DIR'));

        // // ✅ Generar PDF usando Node y Puppeteer locales
        Browsershot::html($htmlContent)
            ->setNodeBinary(env('BROWSERSHOT_NODE_PATH'))
            ->setNpmBinary(env('BROWSERSHOT_NPM_PATH'))
            ->paperSize(900, 650, 'px')
            ->save($fullPath);

        // Guardar registro del certificado
        Certificate::create([
            'user_id' => $user->id,
            'file_path' => 'certificados/' . $user->id . '/' . $pdfFileName,
            'verification_code' => $verificationCode,
            'event' => $event,
            'date' => $date,
        ]);

        Activity::create([
            'type' => 'certificado',
            'title' => 'Certificado emitido',
            'description' => Auth::user()->name . 'de la subred' . Auth::user()->subred .'completó el curso de Inducción',
        ]);

        return response()->download($fullPath);
    }

    // ✅ Validar certificado por código
    public function verificar(Request $request)
    {
        $doc = $request->input('doc');



        // Buscar usuario por número de documento
        $usuario = User::where('document_number', $doc)->first();

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'No se encontró un usuario con ese documento.']);
        }



        // Verificar si tiene certificado
        $certificado = Certificate::where('user_id', $usuario->id)->first();

        if ($certificado) {
            return response()->json([
                'success' => true,
                'user' => $usuario->name,
                'document' => $usuario->document_number,
                'certificado' => $certificado,
                'message' => 'Certificado válido'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Este usuario no tiene certificado registrado.'
            ]);
        }
    }
}
