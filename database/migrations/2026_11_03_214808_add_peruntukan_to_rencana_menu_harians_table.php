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
        Schema::table('rencana_menu_harians', function (Blueprint $table) {
            $table->string('peruntukan')->default('reguler')->after('status');
        });

        // Set existing jus_trainer records to 'trainer'
        DB::table('rencana_menu_harians')->where('waktu', 'jus_trainer')->update(['peruntukan' => 'trainer']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rencana_menu_harians', function (Blueprint $table) {
            $table->dropColumn('peruntukan');
        });
    }
};
