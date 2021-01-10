<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmountPaidToRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewals', function (Blueprint $table) {
            $table->decimal('amount_paid', 20, 2)->after('billingBalance')->default('0.00')->nullable();
            $table->integer('created_by_id')->after('main_acct_id')->nullable();  

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
            Schema::dropIfExists('amount_paid');
            Schema::dropIfExists('created_by_id');
        });
    }
}
