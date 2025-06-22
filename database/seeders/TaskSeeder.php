<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->info('Execute primeiro o CategorySeeder');
            return;
        }

        $tasks = [
            [
                'title' => 'Finalizar relatório mensal',
                'description' => 'Completar o relatório de vendas do mês de dezembro',
                'priority' => 'alta',
                'due_date' => Carbon::now()->addDays(3),
                'completed' => false,
                'category_id' => $categories->where('name', 'Trabalho')->first()->id,
            ],
            [
                'title' => 'Estudar Laravel',
                'description' => 'Revisar conceitos de MVC e Eloquent ORM',
                'priority' => 'media',
                'due_date' => Carbon::now()->addWeek(),
                'completed' => false,
                'category_id' => $categories->where('name', 'Estudos')->first()->id,
            ],
            [
                'title' => 'Comprar ingredientes para jantar',
                'description' => 'Lista: tomate, cebola, alho, carne, temperos',
                'priority' => 'baixa',
                'due_date' => Carbon::now()->addDay(),
                'completed' => true,
                'category_id' => $categories->where('name', 'Compras')->first()->id,
            ],
            [
                'title' => 'Exercitar-se',
                'description' => 'Caminhada de 30 minutos no parque',
                'priority' => 'media',
                'due_date' => Carbon::now(),
                'completed' => false,
                'category_id' => $categories->where('name', 'Saúde')->first()->id,
            ],
            [
                'title' => 'Organizar escritório',
                'description' => 'Limpar e organizar mesa de trabalho',
                'priority' => 'baixa',
                'due_date' => Carbon::now()->addDays(5),
                'completed' => false,
                'category_id' => $categories->where('name', 'Casa')->first()->id,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}