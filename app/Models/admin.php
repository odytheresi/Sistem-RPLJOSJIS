<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class admin extends Model
{
     protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['id_user', 'nm_admin'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
