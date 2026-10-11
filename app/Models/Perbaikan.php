<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perbaikan extends Model
{
    protected $table = 'perbaikan';

    protected $primaryKey = 'id_perbaikan';

    protected $fillable = [
        'id_charger',
        'id_keluhan',
        'tgl_jadwal',
        'jenis_maintenance',
        'keterangan',
        'status',
        'tgl_selesai',
    ];

    protected $casts = [
        'tgl_jadwal' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    public function charger(): BelongsTo
    {
        return $this->belongsTo(
            Charger::class,
            'id_charger',
            'id_charger'
        );
    }

    public function keluhan(): BelongsTo
    {
        return $this->belongsTo(
            Keluhan::class,
            'id_keluhan',
            'id_keluhan'
        );
    }
}