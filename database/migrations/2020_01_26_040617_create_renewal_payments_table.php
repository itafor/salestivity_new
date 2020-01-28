<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productPrice')->nullable();
            $table->integer('billingAmount')->nullable();
            $table->integer('amount_paid')->nullable();
            $table->integer('billingbalance')->nullable();
            $table->integer('discount')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('main_acct_id')->nullable();
            $table->integer('renewal_id')->nullable();
            $table->string('status')->default('Pending')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('renewal_payments');
    }
}
