<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movement_events', function (Blueprint $t) {
            $t->id();
            $t->string('epc', 64)->index();
            $t->timestamp('seen_at')->index();
            $t->string('source', 20)->default('monitor'); // monitor | itag_sync
            $t->json('raw')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('movement_events');
    }
};
