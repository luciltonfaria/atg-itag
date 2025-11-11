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
        // Drop tabelas relacionadas obsoletas (agora usamos escolas/turmas/alunos/tags)
        Schema::dropIfExists('student_tags'); // Depende de students
        Schema::dropIfExists('students');      // Depende de classes
        Schema::dropIfExists('classes');       // Depende de schools
        Schema::dropIfExists('schools');       // Tabela principal obsoleta
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não recriar a tabela schools pois era obsoleta
        // Se precisar reverter, use a tabela escolas que é a correta
    }
};
