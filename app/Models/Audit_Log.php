<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit_Log extends Model
{
     protected $table = 'audit_log';
    protected $primaryKey = 'id_audit';
    public $timestamps = false;

    protected $fillable = ['user_id', 'aktivitas', 'entitas_terkait', 'id_referensi', 'waktu', 'keterangan'];
    protected $casts = ['waktu' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
