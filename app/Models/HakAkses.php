<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HakAkses extends Model
{
    protected $table = 'hak_akses';

    protected $primaryKey = 'id_akses';

    protected $fillable = [
        'id_role',
        'nm_fitur',
        'tambah',
        'hapus',
        'ubah',
        'lihat',
    ];

    public $timestamps = false;

    protected $casts = [
        'tambah' => 'boolean',
        'hapus' => 'boolean',
        'ubah' => 'boolean',
        'lihat' => 'boolean',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            'id_role',
            'id_role'
        );
    }
}