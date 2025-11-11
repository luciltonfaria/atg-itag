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
        Schema::table('escolas', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->after('nome');
            $table->string('logo')->nullable()->after('code');
            $table->string('address', 500)->nullable()->after('logo');
            $table->boolean('active')->default(true)->after('address');

            // Índice único no code (quando preenchido)
            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escolas', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn(['code', 'logo', 'address', 'active']);
        });
    }
};
