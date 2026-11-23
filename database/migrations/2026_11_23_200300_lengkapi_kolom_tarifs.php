<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tarifs', function (Blueprint $table) {
            if (! Schema::hasColumn('tarifs', 'id_charger')) {
                $table->unsignedBigInteger('id_charger')->after('id');
            }
            if (! Schema::hasColumn('tarifs', 'harga_per_kWh')) {
                $table->decimal('harga_per_kWh', 10, 2)->default(0)->after('id_charger');
            }
            if (! Schema::hasColumn('tarifs', 'berlaku_mulai')) {
                $table->date('berlaku_mulai')->nullable()->after('harga_per_kWh');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tarifs', function (Blueprint $table) {
            $table->dropColumn(['id_charger', 'harga_per_kWh', 'berlaku_mulai']);
        });
    }
};