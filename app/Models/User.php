<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'login';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = ['id_role', 'nma_user', 'no_hp', 'email', 'pass', 'status'];
    protected $hidden = ['pass'];

    // Laravel membaca password dari kolom "pass"
    public function getAuthPassword()
    {
        return $this->pass;
    }

    // Tabel login tidak punya kolom remember_token
    public function getRememberTokenName()
    {
        return '';
    }

    public function operator(): HasOne
    {
        return $this->hasOne(Operator::class, 'id_user', 'user_id');
    }
}