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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->string('tipe_kamar')->default('Reguler Twin Bed');
            $table->integer('kapasitas');
            $table->enum('status', ['kosong_bersih', 'kosong_kotor', 'terisi', 'maintenance'])->default('kosong_bersih');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
