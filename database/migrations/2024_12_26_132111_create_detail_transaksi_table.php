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
        if (!Schema::hasTable('detail_transaksi')) {
            Schema::create('detail_transaksi', function (Blueprint $table) {
                $table->id('id_detail_transaksi'); // Primary key
                $table->foreignId('id_transaksi')->constrained('transaksi')->onDelete('cascade'); // Referensi ke transaksi
                $table->foreignId('id_produk')->constrained('produk')->onDelete('cascade'); // Referensi ke produk
                $table->integer('jumlah'); // Jumlah produk
                $table->decimal('harga_satuan', 15, 2); // Harga satuan
                $table->decimal('subtotal', 15, 2)->storedAs('jumlah * harga_satuan'); // Subtotal dihitung otomatis
                $table->timestamps(); // Timestamps created_at, updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
