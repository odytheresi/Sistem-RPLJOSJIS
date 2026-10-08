<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargingStation extends Model
{
    protected $table = 'charging_station';
    protected $primaryKey = 'id_station';
    
    protected $fillable = [
        'id_operator', 'nama_st', 'alamat', 'longitude', 'latitude', 'status'
    ];

    // Relasi: Satu stasiun memiliki banyak charger
    public function chargers(): HasMany
    {
        return $this->hasMany(Charger::class, 'id_station', 'id_station');
    }
}
