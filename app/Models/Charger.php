<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charger extends Model
{
    protected $table = 'charger';
    protected $primaryKey = 'id_charger';
    protected $guarded = [];

    // Relasi ke Charging Station (menggunakan id_station sesuai ERD)
    public function chargingStation()
    {
        return $this->belongsTo(ChargingStation::class, 'id_station', 'id_station');
    }

    // Relasi ke Tipe Konektor (menggunakan id_konektor sesuai ERD)
    public function tipeKonektor()
    {
        return $this->belongsTo(TipeKonektor::class, 'id_konektor', 'id_konektor');
    }

    // Relasi ke Tarif
    public function tarifs()
    {
        return $this->hasMany(Tarif::class, 'id_charger', 'id_charger');
    }
}
