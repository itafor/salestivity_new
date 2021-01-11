<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingBalanceToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
           $table->decimal('billingBalance',20,2)->after('billingAmount')->nullable();
            $table->string('payment_status')->after('status')->nullable();  
            
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
             Schema::dropIfExists('billingBalance');
             Schema::dropIfExists('payment_status');
        });
    }
}
