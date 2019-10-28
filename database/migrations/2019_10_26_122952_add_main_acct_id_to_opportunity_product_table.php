<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainAcctIdToOpportunityProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opportunity_product', function (Blueprint $table) {
            $table->integer('main_acct_id')->after('product_price')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opportunity_product', function (Blueprint $table) {
            $table->dropColumn('main_acct_id');
        });
    }
}
