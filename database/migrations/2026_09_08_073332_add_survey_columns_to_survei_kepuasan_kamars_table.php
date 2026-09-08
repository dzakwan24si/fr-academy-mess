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
        Schema::table('survei_kepuasan_kamars', function (Blueprint $table) {
            $table->integer('kebersihan_kamar')->nullable();
            $table->integer('kebersihan_toilet')->nullable();
            $table->integer('kualitas_makanan')->nullable();
            $table->integer('kenyamanan_fasilitas')->nullable();
            $table->integer('pelayanan_staf')->nullable();
            $table->text('saran_masukan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survei_kepuasan_kamars', function (Blueprint $table) {
            $table->dropColumn([
                'kebersihan_kamar',
                'kebersihan_toilet',
                'kualitas_makanan',
                'kenyamanan_fasilitas',
                'pelayanan_staf',
                'saran_masukan',
            ]);
        });
    }
};
