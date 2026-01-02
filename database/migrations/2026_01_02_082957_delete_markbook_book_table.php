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
        // delete book_id from markbook_readings table
        Schema::table('markbook_readings', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });

        // drop markbook_books table
        Schema::dropIfExists('markbook_books');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
