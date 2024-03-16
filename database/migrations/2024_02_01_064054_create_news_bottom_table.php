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
        Schema::create('news_bottom', function (Blueprint $table) {
            $table->id();
            $table->string('judul_bawah');
            $table->foreignId('category_id')->constrained('news_category')->cascadeOnUpdate()->cascadeOnDelete();
            $table->longText('berita');
            $table->date('tanggal_terbit');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('penulis_berita');
            $table->string('photo_by');
            $table->string('video_file')->nullable();
            $table->string('video_link')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_bottom');
    }
};
