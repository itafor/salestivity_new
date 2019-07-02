<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableOpportunitiesProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_product', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('opportunity_id');
            $table->integer('product_id');
            $table->integer('product_category');
            $table->integer('product_sub_category');
            $table->integer('product_name');
            $table->integer('product_qty');
            $table->integer('product_price');
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
        Schema::dropIfExists('opportunity_product');
    }
}
