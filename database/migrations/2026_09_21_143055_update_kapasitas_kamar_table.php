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
        // Pastikan kolom kapasitas ada
        if (!Schema::hasColumn('kamars', 'kapasitas')) {
            Schema::table('kamars', function (Blueprint $table) {
                $table->integer('kapasitas')->default(1)->after('tipe_kamar');
            });
        }

        // Update data kapasitas
        \Illuminate\Support\Facades\DB::table('kamars')
            ->where('tipe_kamar', 'like', '%Reguler%')
            ->update(['kapasitas' => 2]);

        \Illuminate\Support\Facades\DB::table('kamars')
            ->where('tipe_kamar', 'like', '%Executive%')
            ->orWhere('tipe_kamar', 'like', '%Guest House%')
            ->update(['kapasitas' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
