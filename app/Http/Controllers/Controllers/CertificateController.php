<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\UserModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller {
    public function generate() {
        $user = Auth::user();
        $modules = Module::count() - 1;
        $completed = UserModuleProgress::where('user_id',$user->id)
                        ->where('status','completed')
                        ->whereHas('module', fn($q)=>$q->where('order_index','>',0))
                        ->count();
        if ($completed < $modules) {
            return back()->with('error','Debes completar todos los módulos.');
        }
        $pdf = Pdf::loadView('certificate', compact('user'));
        return $pdf->download('Certificado_'.$user->name.'.pdf');
    }

    
}