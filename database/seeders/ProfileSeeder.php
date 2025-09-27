<?php



namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            'Gestor',
            'Psicólogo',
            'Psicólogo Clínico',
            'Médico',
            'Enfermero',
            'Nutricionista',
            'Ingeniero'
        ];

        foreach ($profiles as $profile) {
            DB::table('profiles')->insert([
                'name' => $profile,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}