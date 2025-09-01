<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Module;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $module = Module::first();

        Quiz::create([
            'module_id' => $module->id,
            'title' => 'Cuestionario de Salud',
            'min_score' => 70,
        ]);
    }
}