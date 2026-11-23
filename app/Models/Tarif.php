<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarif extends Model
{
    protected $table = 'tarifs';

    protected $fillable = ['id_charger', 'harga_per_kWh', 'berlaku_mulai'];

    public function charger(): BelongsTo
    {
        return $this->belongsTo(Charger::class, 'id_charger', 'id_charger');
    }
}