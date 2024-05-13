<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('stock_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained();
            // $table->bigInteger('ref_number');
            $table->integer('quantity');
            $table->text('remarks');
            $table->timestamp('transact_date');
            $table->timestamp('period_from')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('period_to')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('stock_counts');
    }
};
