<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewals', function (Blueprint $table) {
             if (Schema::hasColumn('renewals', 'product'))
            {
            Schema::table('renewals', function (Blueprint $table)
            {
               $table->dropColumn('product');
            });
        }
            $table->integer('category_id')->after('customer_id')->nullable();  
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
        Schema::table('renewals', function (Blueprint $table) {
            Schema::dropIfExists('category_id');
            Schema::dropIfExists('subcategory_id');
            Schema::dropIfExists('product_id');
        });
    }
}
