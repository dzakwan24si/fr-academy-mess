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
        Schema::table('pemotongan_stoks', function (Blueprint $table) {
            $table->decimal('jumlah_dipotong', 10, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemotongan_stoks', function (Blueprint $table) {
            $table->integer('jumlah_dipotong')->change();
        });
    }
};
