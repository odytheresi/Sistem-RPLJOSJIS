<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = ['nma_role', 'status'];
    public $timestamps = false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }

    public function hakAkses(): HasMany
    {
        return $this->hasMany(hak_akses::class, 'id_role', 'id_role');
    }
}