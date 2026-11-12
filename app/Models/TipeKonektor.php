<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipeKonektor extends Model
{
    protected $table = 'tipe_konektor';

    protected $primaryKey = 'id_konektor';

    protected $fillable = [
        'nama_konektor',
        'jenis_charging',
    ];

    public function chargers(): HasMany
    {
        return $this->hasMany(
            Charger::class,
            'id_konektor',
            'id_konektor'
        );
    }
}