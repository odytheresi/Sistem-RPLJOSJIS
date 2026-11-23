<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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

    /** Dipanggil dari setiap aksi penting. Admin tidak mengisi apa pun. */
    public static function catat(
        string $aktivitas,
        ?string $keterangan = null,
        ?string $entitas = null,
        ?string $idReferensi = null,
        ?int $idUser = null
    ): void {
        static::create([
            'id_user'         => $idUser ?? Auth::id(),
            'aktivitas'       => $aktivitas,
            'entitas_terkait' => $entitas,
            'id_referensi'    => $idReferensi,
            'keterangan'      => $keterangan,
            'waktu'           => now(),
        ]);
    }
}