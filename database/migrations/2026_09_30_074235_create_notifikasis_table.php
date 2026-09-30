<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $t) {
            $t->id('id_notif');
            $t->foreignId('id_user')->constrained('user', 'id_user')->cascadeOnDelete();
            $t->enum('jenis', ['Selesai', 'Pending', 'Gagal']);
            $t->string('judul');
            $t->text('isi');
            $t->boolean('status_baca')->default(false);
            $t->timestamp('waktu')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
