<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('action', 100); // Ex.: Acesso, Criar, Atualizar, Excluir, Exportar CSV, Imprimir
            $table->string('page', 255);   // Rota ou URL
            $table->boolean('is_export')->default(false);
            $table->boolean('is_print')->default(false);
            $table->timestamps(); // created_at será a Data/Horário
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};