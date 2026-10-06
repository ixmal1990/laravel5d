<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_type_id')->constrained('property_types')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name'); // e.g. SmartKost Executive Banjarbaru
            $table->text('address');
            $table->string('city')->default('Banjarbaru');
            $table->text('description')->nullable();
            $table->text('rules')->nullable(); // e.g. Dilarang merokok, Jam berkunjung max 22.00
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
