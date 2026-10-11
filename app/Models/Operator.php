<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operator extends Model
{
    protected $table = 'operator';

    protected $primaryKey = 'id_operator';

    protected $fillable = [
        'id_user',
        'nama_operator',
        'no_hp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id'
        );
    }

    public function stations(): HasMany
    {
        return $this->hasMany(
            ChargingStation::class,
            'id_operator',
            'id_operator'
        );
    }
}