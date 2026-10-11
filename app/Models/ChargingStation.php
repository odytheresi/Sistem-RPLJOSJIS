<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChargingStation extends Model
{
    protected $table = 'charging_station'; // samakan dengan nama tabel di migrasimu

    protected $primaryKey = 'id_station';

    protected $fillable = [
        'id_operator',
        'nama_station',
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

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class, 'id_station', 'id_station');
    }

    public function keluhan(): HasMany
    {
        return $this->hasMany(Keluhan::class, 'id_station', 'id_station');
    }
}