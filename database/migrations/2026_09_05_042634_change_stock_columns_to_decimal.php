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
            $table->decimal('stok', 10, 3)->default(0)->change();
        });

        Schema::table('resep_bahan', function (Blueprint $table) {
            $table->decimal('jumlah_dibutuhkan', 10, 3)->change();
        });

        Schema::table('pemotongan_stoks', function (Blueprint $table) {
            $table->decimal('jumlah_dipotong', 10, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->integer('stok')->default(0)->change();
        });

        Schema::table('resep_bahan', function (Blueprint $table) {
            $table->integer('jumlah_dibutuhkan')->change();
        });

        Schema::table('pemotongan_stoks', function (Blueprint $table) {
            $table->integer('jumlah_dipotong')->change();
        });
    }
};
