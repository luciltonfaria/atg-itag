<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('escolas', function (Blueprint $t) {
            $t->id();
            $t->string('nome', 120)->unique();
            $t->timestamps();
        });

        Schema::create('turmas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('escola_id')->constrained('escolas')->cascadeOnDelete();
            $t->string('nome', 120);
            $t->timestamps();
            $t->unique(['escola_id', 'nome']);
        });

        Schema::create('alunos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('turma_id')->constrained('turmas')->cascadeOnDelete();
            $t->string('nome', 160);
            $t->string('referencia', 60)->nullable()->index(); // CPF ou código
            $t->timestamps();
            // Opcional: evitar duplicidade grosseira
            $t->unique(['turma_id', 'nome']);
        });

        Schema::create('tags', function (Blueprint $t) {
            $t->id();
            $t->string('epc', 64)->unique();
            $t->foreignId('aluno_id')->constrained('alunos')->cascadeOnDelete();
            $t->boolean('ativo')->default(true);
            $t->timestamps();
        });

        // Se já houver 'movement_events', só garanta índices úteis
        if (Schema::hasTable('movement_events') && !Schema::hasColumn('movement_events', 'antenna')) {
            Schema::table('movement_events', function (Blueprint $t) {
                $t->string('antenna', 40)->nullable()->after('source');
                $t->integer('rssi')->nullable()->after('antenna');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('alunos');
        Schema::dropIfExists('turmas');
        Schema::dropIfExists('escolas');
    }
};
