<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charger extends Model
{
    protected $table = 'charger';
    protected $primaryKey = 'id_charger';
    
    protected $fillable = [
        'id_station', 'id_konektor', 'kd_charger', 'daya_maks', 'status'
    ];

    // Relasi: Charger milik satu stasiun
    public function station(): BelongsTo
    {
        return $this->belongsTo(ChargingStation::class, 'id_station', 'id_station');
    }
}
