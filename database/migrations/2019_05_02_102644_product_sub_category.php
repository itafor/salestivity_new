<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductSubCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sub_categories', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned();
            $table->integer('sub_category_id')->unsigned();
        });

        // Schema::table('product_sub_categories', function(Blueprint $table) {
        //     $table->foreign('product_id')->references('id')->on('products')
        //             ->onDelete('cascade')->unsigned();
        //     $table->foreign('sub_category_id')->references('id')->on('sub_categories')
        //             ->onDelete('cascade')->unsigned();
            
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
