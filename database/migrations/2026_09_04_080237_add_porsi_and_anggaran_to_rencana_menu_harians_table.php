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
        Schema::table('rencana_menu_harians', function (Blueprint $table) {
            $table->integer('target_porsi')->default(0)->after('status');
            $table->decimal('estimasi_anggaran', 12, 2)->default(0)->after('target_porsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rencana_menu_harians', function (Blueprint $table) {
            $table->dropColumn(['target_porsi', 'estimasi_anggaran']);
        });
    }
};
