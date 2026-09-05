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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('deskripsi');
            $table->string('waktu_penyajian')->nullable()->after('kategori');
            $table->decimal('estimasi_harga_porsi', 12, 2)->default(0)->after('waktu_penyajian');
            $table->boolean('is_active')->default(true)->after('estimasi_harga_porsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'waktu_penyajian', 'estimasi_harga_porsi', 'is_active']);
        });
    }
};
