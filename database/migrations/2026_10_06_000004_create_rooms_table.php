<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('room_number'); // e.g. Room A-101
            $table->string('room_type'); // e.g. Deluxe AC, Standard Fan, VIP Balcony
            $table->decimal('monthly_rate', 10, 2);
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->integer('size_m2')->default(12);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
