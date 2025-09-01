<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        Module::create([
            'title' => 'Módulo de Salud',
            'description' => 'Este módulo contiene preguntas sobre salud general.',
        ]);
    }
}