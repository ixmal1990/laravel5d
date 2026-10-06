<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->onDelete('cascade');
            $table->foreignId('console_id')->constrained()->onDelete('cascade');
            $table->integer('duration_days')->default(1);
            $table->decimal('daily_rate_snapshot', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('late_fee', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
