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
        Schema::create('audit_log', function (Blueprint $t) {
            $t->id('id_audit');
            $t->foreignId('id_user')->nullable()->constrained('user', 'id_user');
            $t->string('aktivitas', 100);
            $t->string('entitas_terkait', 100)->nullable();
            $t->string('id_referensi', 50)->nullable();
            $t->timestamp('waktu')->useCurrent();
            $t->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit__log');
    }
};
