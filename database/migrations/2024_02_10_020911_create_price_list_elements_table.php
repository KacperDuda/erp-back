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
        Schema::create('price_list_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price_list_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('price'); // cena w groszach
            $table->double('vat');
            $table->timestamps();

            // IMPORTANT! names have to be in an array, otherwise they count separately
            $table->unique(['price_list_id', 'product_id']); // impossible to have two elements referencing same models

            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_list_elements');
    }
};
