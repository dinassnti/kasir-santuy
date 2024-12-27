<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_staff', 'id_diskon', 'jumlah_bayar', 'kembalian', 'nomor_transaksi'
    ];

    // Menambahkan nomor transaksi secara otomatis
    public static function boot()
    {
        parent::boot();
    
        // Sebelum menyimpan transaksi, buat nomor transaksi unik
        static::creating(function ($transaksi) {
            // Menentukan nomor transaksi dengan format tertentu, misalnya "TRX-YYYYMMDD-001"
            $transaksi->nomor_transaksi = 'TRX-' . now()->format('Ymd') . '-' . str_pad($transaksi->id_transaksi, 3, '0', STR_PAD_LEFT);
        });
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'id_diskon');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id_staff');
    }
}