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
        Schema::create('transaksi_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('from_bank_id')->constrained('banks');
            $table->foreignId('to_bank_id')->constrained('banks');
            $table->foreignId('admin_rekening_id')->constrained('rekening_admins');
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('unique_code', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_transfers');
    }
};
