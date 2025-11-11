<?php

use App\Models\Markbook\Book;
use App\Models\Player;
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
        Schema::create('markbook_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class)->constrained((new Book)->getTable())->onDelete('cascade');
            $table->foreignIdFor(Player::class)->constrained((new Player)->getTable())->onDelete('cascade');
            $table->unsignedSmallInteger('pages_read');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markbook_readings');
    }
};
