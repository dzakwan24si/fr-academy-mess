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
        Schema::table('tamus', function (Blueprint $table) {
            $table->enum('kategori', ['tamu_umum', 'trainee'])->default('tamu_umum')->after('jabatan');
        });

        Schema::table('reservasis', function (Blueprint $table) {
            $table->time('perkiraan_jam_checkin')->nullable()->after('tanggal_checkout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });

        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn('perkiraan_jam_checkin');
        });
    }
};
