<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Login extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'login';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'id_role', 'nma_user', 'no_hp', 'email', 'pass', 'status'
    ];

    public function getAuthPassword()
    {
        return $this->pass;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}
