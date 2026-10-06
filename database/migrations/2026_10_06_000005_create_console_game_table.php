<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('console_game', function (Blueprint $table) {
            $table->id();
            $table->foreignId('console_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->timestamp('installed_at')->useCurrent();
            $table->integer('storage_size_gb');
            $table->timestamps();

            $table->unique(['console_id', 'game_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('console_game');
    }
};
