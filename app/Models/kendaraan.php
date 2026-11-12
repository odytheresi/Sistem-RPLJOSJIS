<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraans';
    protected $primaryKey = 'id_kendaraan';

    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'no_plat',
        'merk',
        'model',
        'kapasitas_baterai',
    ];

    public function pengemudi()
    {
        return $this->belongsTo(
            Pengemudi::class,
            'user_id',
            'user_id'
        );
    }
}