<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengemudi extends Authenticatable
{
    use Notifiable;
    protected $table = 'pengemudi';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_role',
        'nma_user',
        'no_hp',
        'email',
        'pass',
        'status',
    ];

    protected $hidden = [
        'pass',
    ];

    /**
     * Kolom password yang digunakan Laravel untuk autentikasi.
     */
    public function getAuthPassword()
    {
        return $this->pass;
    }

    /**
     * Relasi ke kendaraan milik pengemudi.
     */
    public function kendaraan()
    {
        return $this->hasMany(kendaraan::class, 'user_id', 'user_id');
    }
}
