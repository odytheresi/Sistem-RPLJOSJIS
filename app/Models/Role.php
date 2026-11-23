<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\HakAkses;

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
        return $this->hasMany(HakAkses::class, 'id_role', 'id_role');
    }
}