<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    
    protected $table = 'staff'; 
    protected $primaryKey = 'id_staff'; 
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'nama', 'email', 'no_telepon', 'alamat', 'password', 'status_aktif'
    ];

public function user()
{
    return $this->belongsTo(User::class, 'email', 'email');
}

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_staff');
    }
}
