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
        DB::statement("ALTER TABLE rencana_menu_harians MODIFY waktu ENUM('pagi', 'siang', 'malam', 'jus_trainer') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting this might drop 'jus_trainer' records if they exist, but normally we'd do:
        DB::statement("ALTER TABLE rencana_menu_harians MODIFY waktu ENUM('pagi', 'siang', 'malam') NOT NULL");
    }
};
