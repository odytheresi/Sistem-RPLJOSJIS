<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->foreignId('id_role')->constrained('role', 'id_role');
            $table->string('identifier', 50)->unique();   // NIP (AN001/OP001) atau username pengemudi
            $table->string('email')->unique();
            $table->string('password');                    // isi dengan hash, bukan teks asli
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};