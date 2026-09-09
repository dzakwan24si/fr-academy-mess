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
        Schema::table('komplain_kerusakans', function (Blueprint $table) {
            $table->text('catatan_teknisi')->nullable();
            $table->string('foto_perbaikan')->nullable();
        });

        Schema::table('aset_kamar', function (Blueprint $table) {
            $table->text('catatan_perbaikan')->nullable();
            $table->string('foto_perbaikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komplain_kerusakans', function (Blueprint $table) {
            $table->dropColumn(['catatan_teknisi', 'foto_perbaikan']);
        });

        Schema::table('aset_kamar', function (Blueprint $table) {
            $table->dropColumn(['catatan_perbaikan', 'foto_perbaikan']);
        });
    }
};
