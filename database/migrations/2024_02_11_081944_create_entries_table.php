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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('client_id');
            $table->string('color')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('unit_price');
            $table->double('vat');
            $table->boolean('left');
            $table->date('posting_date');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
