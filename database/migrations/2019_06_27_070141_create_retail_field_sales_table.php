<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailFieldSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_field_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');            
            $table->integer('quantity');            
            $table->integer('price');            
            $table->integer('total_amount');            
            $table->string('sales_person_id');            
            $table->integer('location_id');            
            $table->integer('main_acct_id');            
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
        Schema::dropIfExists('retail_field_sales');
    }
}
