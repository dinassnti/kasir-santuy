<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskon'; // Nama tabel di database

    protected $primaryKey = 'id_diskon'; // Primary key

    // Kolom yang dapat diisi (fillable)
    protected $fillable = [
        'user_id',
        'nama_diskon',
        'persentase',
        'nominal',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_diskon');
    }

}
