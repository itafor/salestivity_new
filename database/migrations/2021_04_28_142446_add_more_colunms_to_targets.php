<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColunmsToTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targets', function (Blueprint $table) {
            if (Schema::hasColumn('targets', 'unit_price'))
            {
            Schema::table('targets', function (Blueprint $table)
            {
               $table->dropColumn('unit_price');
               $table->dropColumn('amount');
               $table->dropColumn('qty');
               $table->dropColumn('product_id');
               $table->dropColumn('status');
            });
          }

            $table->decimal('unit_price', 20, 2)->after('percentage')->nullable();
            $table->decimal('amount', 20, 2)->after('unit_price')->nullable();
            $table->integer('qty')->after('amount')->nullable();
            $table->integer('product_id')->after('qty')->nullable();
            $table->integer('status')->after('product_id')->nullable();
            $table->date('start_date')->after('status')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('targets', function (Blueprint $table) {
            Schema::dropIfExists(['unit_price','amount','qty','product_id','status','start_date','end_date']);
        });
    }
}
