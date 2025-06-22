<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Trabalho',
            'Pessoal',
            'Estudos',
            'Casa',
            'Saúde',
            'Compras',
            'Projetos',
            'Lazer'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}