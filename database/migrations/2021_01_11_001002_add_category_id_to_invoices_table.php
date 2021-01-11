<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
         if (Schema::hasColumn('invoices', 'product'))
            {
            Schema::table('invoices', function (Blueprint $table)
            {
               $table->dropColumn('product');
            });
        }
            $table->integer('category_id')->after('customer')->nullable();  
            $table->integer('subcategory_id')->after('category_id')->nullable(); 
            $table->integer('product_id')->after('subcategory_id')->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            Schema::dropIfExists('category_id');
            Schema::dropIfExists('subcategory_id');
            Schema::dropIfExists('product_id');
        });
    }
}
