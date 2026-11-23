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
        Schema::table('user', function (Blueprint $table) {
             $table->unsignedTinyInteger('failed_login')->default(0)->after('status');
            $table->timestamp('locked_until')->nullable()->after('failed_login');
         });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', fn (Blueprint $t) => 
            $t->dropColumn(['failed_login', 'locked_until']));
    }
};
