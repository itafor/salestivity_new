<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToRetailFieldSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retail_field_sales', function (Blueprint $table) {
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retail_field_sales', function (Blueprint $table) {
            Schema::dropIfExists(['category_id','sub_category_id']);
        });
    }
}
