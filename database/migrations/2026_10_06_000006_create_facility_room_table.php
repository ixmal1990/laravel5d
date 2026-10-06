<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facility_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('facility_id')->constrained()->onDelete('cascade');
            $table->string('condition')->default('good'); // e.g. new, good, fair
            $table->timestamp('installed_at')->useCurrent();
            $table->timestamps();

            $table->unique(['room_id', 'facility_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_room');
    }
};
