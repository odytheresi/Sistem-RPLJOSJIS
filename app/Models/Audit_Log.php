<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audit_Log extends Model
{
     protected $table = 'audit_log';
    protected $primaryKey = 'id_audit';
    public $timestamps = false;

    protected $fillable = ['id_user', 'aktivitas', 'entitas_terkait', 'id_referensi', 'waktu', 'keterangan'];
    protected $casts = ['waktu' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
