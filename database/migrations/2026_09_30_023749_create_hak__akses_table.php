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
       Schema::create('hak_akses', function (Blueprint $table) {
            $table->id('id_akses');
            $table->foreignId('id_role')->constrained('role', 'id_role');   // FK ke role.id_role
            $table->string('nm_fitur', 50);                // kode teks, mis. kelola_stasiun (daftar di config/fitur.php)
            $table->boolean('lihat')->default(false);
            $table->boolean('tambah')->default(false);
            $table->boolean('ubah')->default(false);
            $table->boolean('hapus')->default(false);
            $table->timestamps();
 
            $table->unique(['id_role', 'nm_fitur']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hak__akses');
    }
};
