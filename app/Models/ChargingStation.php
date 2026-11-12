<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ChargingStation extends Model
{
    protected $table = 'charging_station';

    protected $primaryKey = 'id_station';

    protected $fillable = [
        'id_operator',
        'nama_st',
        'alamat',
        'latitude',
        'longitude',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_station';
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id_operator', 'id_operator');
    }

    public function chargers(): HasMany
    {
        return $this->hasMany(Charger::class, 'id_station', 'id_station');
    }

    public function tarifs(): HasManyThrough
    {
        return $this->hasManyThrough(
            Tarif::class,
            Charger::class,
            'id_station',   // FK di charger
            'id_charger',   // FK di tarifs
            'id_station',   // PK lokal station
            'id_charger'    // PK lokal charger
        );
    }

    public function keluhan(): HasMany
    {
        return $this->hasMany(Keluhan::class, 'id_station', 'id_station');
    }
}