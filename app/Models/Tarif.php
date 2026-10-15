<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarifs'; // Diubah dari 'tarif' menjadi 'tarifs'
    protected $primaryKey = 'id_tarif';
    protected $guarded = [];

    // Relasi ke tabel charger
    public function charger()
    {
        return $this->belongsTo(Charger::class, 'id_charger', 'id_charger');
    }
}