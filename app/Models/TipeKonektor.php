<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeKonektor extends Model
{
    protected $table = 'tipe_konektor';
    protected $primaryKey = 'id_konektor';
    protected $guarded = [];

    // Relasi ke tabel charger
    public function chargers()
    {
        return $this->hasMany(Charger::class, 'id_konektor', 'id_konektor');
    }
}