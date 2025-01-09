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
        if (!Schema::hasTable('transaksi')) {
            Schema::create('transaksi', function (Blueprint $table) {
                $table->id('id_transaksi'); // Primary key
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Referensi ke users
                $table->foreignId('id_diskon')->nullable()->constrained('diskon')->onDelete('set null'); // Referensi ke diskon
                $table->decimal('jumlah_bayar', 15, 2); // Jumlah bayar
                $table->decimal('kembalian', 15, 2); // Kembalian
                $table->timestamp('log_waktu')->useCurrent(); // Log waktu
                $table->timestamps(); // Timestamps created_at, updated_at
            });        
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
