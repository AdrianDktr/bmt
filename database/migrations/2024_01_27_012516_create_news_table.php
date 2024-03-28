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
        // ,
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->default('');
            $table->longText('isi');
            $table->foreignId('category_id')->constrained('news_category')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('penulis_berita')->nullable();
            $table->string('photo_by')->nullable();
            $table->date('tanggal_terbit')->default(date('Y-m-d'));
            $table->string('video_file')->nullable();
            $table->string('video_link')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
