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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // used as email recipient name
            $table->unsignedBigInteger('price_list_id'); // dedicated price list
            $table->string('name'); // for email and invoice - official
            $table->string('email')->nullable(); // for email
            $table->string('nickname'); // dla pracowników
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('additional_info')->nullable();
            $table->bigInteger('NIP')->nullable();
            $table->boolean('is_company');
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('price_list_id')->references('id')->on('price_lists');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
