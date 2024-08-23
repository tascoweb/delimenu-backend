<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\TenantFactory;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criação de planos
        $freePlan = Plan::firstOrCreate(
            ['name' => 'Free Plan'],
            ['url' => 'free-plan', 'price' => 0.00, 'description' => 'Plano gratuito']
        );

        $premiumPlan = Plan::firstOrCreate(
            ['name' => 'Premium Plan'],
            ['url' => 'premium-plan', 'price' => 29.90, 'description' => 'Plano premium']
        );
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);


        // Criação de features
        $features = Feature::factory()->count(10)->create();

        // Vincular features aos planos
        $freePlan->features()->sync($features->random(3)->pluck('id')->toArray()); // 3 features aleatórias para o plano gratuito
        $premiumPlan->features()->sync($features->pluck('id')->toArray()); // Todas as features para o plano premium

        // Criação de tenants
        $tenants = Tenant::factory()->count(5)->create(); // Usando o modelo correto

        // Criação de companies e usuários
        $tenants->each(function ($tenant) use ($freePlan, $premiumPlan, $roleAdmin, $roleUser) {
            // Criar uma empresa para cada tenant
            $company = Company::factory()->create([
                'tenant_id' => $tenant->id,
                'plan_id' => rand(0, 1) ? $freePlan->id : $premiumPlan->id,
            ]);

            // Criar 3 usuários para cada empresa (1 admin e 2 usuários comuns)
            $users = User::factory()->count(3)->create([
                'tenant_id' => $tenant->id,
            ]);

            $users->each(function ($user) use ($company) {
                $user->companies()->attach($company->id);
            });

            $users->first()->assignRole($roleAdmin);
            $users->skip(1)->first()->assignRole($roleUser);

        });
    }
}
