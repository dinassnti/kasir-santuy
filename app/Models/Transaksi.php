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
        'user_id', 'id_diskon', 'jumlah_bayar', 'kembalian',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
    
    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'id_diskon');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}