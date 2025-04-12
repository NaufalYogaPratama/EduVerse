<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Material::create([
            'user_id' => 1, // Ganti dengan ID user yang ada
            'title' => 'Sample Material',
            'description' => 'This is a sample material',
            'approved' => false,
        ]);
    }
}
