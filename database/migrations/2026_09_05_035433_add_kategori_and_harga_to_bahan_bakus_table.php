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
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->enum('kategori_bahan', ['Kering', 'Basah'])->default('Kering')->after('nama_bahan');
            $table->decimal('harga_satuan', 12, 2)->default(0)->after('kategori_bahan');
            $table->string('keterangan_volume')->nullable()->after('harga_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->dropColumn(['kategori_bahan', 'harga_satuan', 'keterangan_volume']);
        });
    }
};
