<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Charger extends Model
{
    protected $table = 'charger';

    protected $primaryKey = 'id_charger';

    protected $fillable = [
        'id_station',
        'id_konektor',
        'kode_charger',
        'daya_maks',
        'status',
    ];

    protected $casts = [
        'daya_maks' => 'decimal:2',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(
            ChargingStation::class,
            'id_station',
            'id_station'
        );
    }

    public function konektor(): BelongsTo
    {
        return $this->belongsTo(
            TipeKonektor::class,
            'id_konektor',
            'id_konektor'
        );
    }

    public function tarifs(): HasMany
    {
        return $this->hasMany(
            Tarif::class,
            'id_charger',
            'id_charger'
        );
    }

    public function perbaikan(): HasMany
    {
        return $this->hasMany(
            Perbaikan::class,
            'id_charger',
            'id_charger'
        );
    }
}