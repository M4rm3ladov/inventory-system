<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->foreignId('unit_id');
            $table->foreignId('item_category_id');
            $table->string('code');
            $table->string('description');
            $table->string('add_description');
            $table->float('unit_price');
            $table->float('price_A');
            $table->float('price_B');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
