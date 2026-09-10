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
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan');
            $table->enum('kategori_bahan', ['Kering', 'Basah'])->default('Kering');
            $table->decimal('harga_satuan', 12, 2)->default(0);
            $table->string('keterangan_volume')->nullable();
            $table->decimal('stok', 10, 3)->default(0);
            $table->string('satuan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
