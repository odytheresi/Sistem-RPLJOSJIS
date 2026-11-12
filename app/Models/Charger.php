<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charger extends Model
{
    protected $table = 'charger';
    protected $primaryKey = 'id_charger';
    public $timestamps = false;

    protected $fillable = [
        'id_station',
        'id_konektor',
        'kd_charger',
        'daya_maks',
        'status',
    ];
}
