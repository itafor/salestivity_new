<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTypeToRenewalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewal_payments', function (Blueprint $table) {
             $table->integer('created_by_id')->after('main_acct_id')->nullable(); 
             $table->string('user_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renewal_payments', function (Blueprint $table) {
            Schema::dropIfExists('created_by_id');
            Schema::dropIfExists('user_type');
        });
    }
}
