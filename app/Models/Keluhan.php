<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keluhan extends Model
{
    protected $table = 'keluhan';

    protected $primaryKey = 'id_keluhan';

    protected $fillable = [
        'id_pengemudi',
        'id_station',
        'id_sesi',
        'isi_keluhan',
        'status',
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(
            ChargingStation::class,
            'id_station',
            'id_station'
        );
    }

    public function perbaikan(): HasMany
    {
        return $this->hasMany(
            Perbaikan::class,
            'id_keluhan',
            'id_keluhan'
        );
    }


}