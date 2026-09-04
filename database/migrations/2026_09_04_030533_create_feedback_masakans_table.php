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
        Schema::create('feedback_masakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rencana_menu_harian_id')->constrained('rencana_menu_harians')->onDelete('cascade');
            $table->foreignId('tamu_id')->constrained('tamus')->onDelete('cascade');
            $table->integer('rating');
            $table->text('komentar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_masakans');
    }
};
