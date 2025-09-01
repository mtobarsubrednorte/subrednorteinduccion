<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModuleProgress;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
    public function index() {
        $report = UserModuleProgress::select(
            'user_id',
            DB::raw('SUM(CASE WHEN status="completed" THEN 1 ELSE 0 END) as modulos_completos'),
            DB::raw('COUNT(*) as total_modulos')
        )->groupBy('user_id')->get();
        return view('admin.reportes', compact('report'));
    }
}