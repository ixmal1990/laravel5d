<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code')->unique();
            $table->foreignId('lease_id')->constrained()->onDelete('cascade');
            $table->string('period_month'); // e.g. 2026-10
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'qris', 'bank_transfer', 'e_wallet']);
            $table->enum('status', ['pending', 'paid', 'late', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
