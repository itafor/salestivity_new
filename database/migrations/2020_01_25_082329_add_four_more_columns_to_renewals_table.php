<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFourMoreColumnsToRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewals', function (Blueprint $table) {
            $table->integer('productPrice')->after('amount')->nullable();
            $table->integer('discount')->after('amount')->nullable();
            $table->integer('billingAmount')->after('amount')->nullable();
            $table->string('description')->after('amount')->nullable();
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
            $table->integer('productPrice');
            $table->integer('discount');
            $table->integer('billingAmount');
            $table->string('description');
        });
    }
}
