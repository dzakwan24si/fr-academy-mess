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
        Schema::create('survei_kepuasan_kamars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained('reservasis')->onDelete('cascade');
            $table->integer('rating');
            $table->text('komentar')->nullable();
            $table->integer('kebersihan_kamar')->nullable();
            $table->integer('kebersihan_toilet')->nullable();
            $table->integer('kualitas_makanan')->nullable();
            $table->integer('kenyamanan_fasilitas')->nullable();
            $table->integer('pelayanan_staf')->nullable();
            $table->text('saran_masukan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_kepuasan_kamars');
    }
};
