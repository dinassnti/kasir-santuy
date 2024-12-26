<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up()
    {
        if (!Schema::hasTable('produk')) {
            Schema::create('produk', function (Blueprint $table) {
                $table->id('id_produk');
                $table->foreignId('id_kategori')->constrained('kategori');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('kode_barang')->unique(); 
                $table->string('nama_produk');
                $table->double('harga_dasar');
                $table->double('harga_jual');
                $table->integer('stok')->default(0);
                $table->string('foto')->nullable();
                $table->timestamps();
            });

            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        }
    }


    /**
     * Balikkan migration.
     */
    public function down()
    {
        Schema::dropIfExists('produk'); // Menghapus tabel produk saat rollback
    }
}
