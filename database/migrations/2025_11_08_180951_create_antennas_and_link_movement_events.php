<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabela de antenas
        if (!Schema::hasTable('antennas')) {
            Schema::create('antennas', function (Blueprint $t) {
                $t->id();
                $t->foreignId('escola_id')->constrained('escolas')->cascadeOnDelete();
                $t->string('codigo', 20);          // número físico (porta) ou identificador do leitor
                $t->string('descricao')->nullable(); // "Portão Principal", etc.
                $t->boolean('ativo')->default(true);
                $t->timestamps();
                $t->unique(['escola_id', 'codigo']);
            });
        }

        // Colunas em movement_events
        if (!Schema::hasColumn('movement_events', 'antenna_id')) {
            Schema::table('movement_events', function (Blueprint $t) {
                $t->foreignId('antenna_id')
                    ->nullable()
                    ->constrained('antennas')
                    ->nullOnDelete()
                    ->after('source');
            });
        }

        if (!Schema::hasColumn('movement_events', 'antenna')) {
            Schema::table('movement_events', function (Blueprint $t) {
                $t->string('antenna', 40)->nullable()->after('antenna_id');
            });
        }

        if (!Schema::hasColumn('movement_events', 'rssi')) {
            Schema::table('movement_events', function (Blueprint $t) {
                $t->integer('rssi')->nullable()->after('antenna');
            });
        }
    }

    public function down(): void
    {
        // Remover FK antes
        if (Schema::hasColumn('movement_events', 'antenna_id')) {
            Schema::table('movement_events', function (Blueprint $t) {
                $t->dropConstrainedForeignId('antenna_id');
                $t->dropColumn(['antenna_id', 'antenna', 'rssi']);
            });
        }
        Schema::dropIfExists('antennas');
    }
};
