<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('target_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->decimal('unit_price', 20, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('target_products');
    }
}
