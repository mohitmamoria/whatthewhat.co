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
        Schema::create('bookscan_entries', function (Blueprint $table) {
            $table->id();
            $table->string('shopify_order_id');
            $table->string('vendor');
            $table->date('date');
            $table->string('sku');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('shipping_pin_code')->nullable();
            $table->boolean('is_received_gift')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookscan_entries');
    }
};
