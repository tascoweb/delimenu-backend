<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->string('name');
            $table->uuid();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->string('cnpj')->unique();
            $table->string('url')->unique();

            // Status do Tenant (Ativo, Inativo)
            $table->enum('active', ['Y', 'N'])->default('Y');

            // Subscription
            $table->date('subscription')->nullable(); // Data de inscrição
            $table->date('expires_at')->nullable(); // Data de expiração
            $table->integer('subscription_id')->nullable(); // Identificador da assinatura
            $table->enum('subscription_status',['active','inactive','suspended'])->default('inactive'); // Status da assinatura
            $table->foreignId('plan_id')->constrained('plans');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
