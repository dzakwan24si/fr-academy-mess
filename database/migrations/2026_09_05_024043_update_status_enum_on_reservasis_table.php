<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter ENUM values to match the new Admin workflow
        DB::statement("ALTER TABLE reservasis MODIFY COLUMN status ENUM('pending', 'approved', 'checked_in', 'completed', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE reservasis MODIFY COLUMN status ENUM('pending', 'aktif', 'selesai', 'batal', 'ditolak') DEFAULT 'pending'");
    }
};
