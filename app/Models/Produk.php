<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = true;

    // Specify which columns are mass-assignable
    protected $fillable = [
        'user_id',
        'id_kategori',
        'kode_barang',
        'nama_produk',
        'harga_dasar',
        'harga_jual',
        'stok',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function getDiscountedPrice()
    {
        return $this->harga_jual - ($this->harga_dasar * 0.1); 
    }

    // Opsional, jika Anda ingin menangani penyimpanan file untuk bidang 'foto'
    public function getFotoUrlAttribute()
    {
        return asset('storage/'.$this->foto);  // Dengan asumsi foto disimpan di direktori 'penyimpanan'
    }
}
