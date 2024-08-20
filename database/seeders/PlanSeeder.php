<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Plan::where('name', 'Free Plan')->exists()){
            Plan::factory()->free()->create([
                'description' => 'Plano gratuito para sempre com recursos básicos.',
            ]);
        }

        if(!Plan::where('name', 'Premium Plan')->exists()){
            Plan::factory()->premium()->create([
                'description' => 'Plano premium com todos os recursos por R$29,90 por mês.',
            ]);
        }
    }
}
