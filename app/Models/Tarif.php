<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarif extends Model
{
    protected $table = 'tarif';

    protected $primaryKey = 'id_tarif';

    protected $fillable = [
        'id_station',
        'id_charger',
        'harga_per_kwh',
        'berlaku_mulai',
        'berlaku_selesai',
    ];

    protected $casts = [
        'harga_per_kwh' => 'decimal:2',
        'berlaku_mulai' => 'datetime',
        'berlaku_selesai' => 'datetime',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(
            ChargingStation::class,
            'id_station',
            'id_station'
        );
    }

    public function charger(): BelongsTo
    {
        return $this->belongsTo(
            Charger::class,
            'id_charger',
            'id_charger'
        );
    }
}