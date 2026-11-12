<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiCharger extends Model
{
    protected $table = 'sesi_charger';
    protected $primaryKey = 'id_sesi';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'id_charger',
        'id_kendaraan',
        'id_tarif',
        'wkt_mulai',
        'wkt_selesai',
        'energi_pakai',
        'durasi',
        'total_bayar',
        'status',
    ];

    protected $casts = [
        'wkt_mulai' => 'datetime',
        'wkt_selesai' => 'datetime',
        'energi_pakai' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];
}
