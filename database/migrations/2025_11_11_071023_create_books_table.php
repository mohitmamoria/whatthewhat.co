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
        Schema::create('markbook_books', function (Blueprint $table) {
            $table->id();
            $table->string('openlibrary_work_id')->unique();
            $table->string('google_books_volume_id')->unique();
            $table->string('title');
            $table->json('authors');
            $table->string('cover_image_url')->nullable();
            $table->string('published_year')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markbook_books');
    }
};
