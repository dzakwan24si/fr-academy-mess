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
        Schema::create('rencana_menu_harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('waktu', ['pagi', 'siang', 'malam']);
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'sedang_masak', 'selesai'])->default('menunggu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_menu_harians');
    }
};
