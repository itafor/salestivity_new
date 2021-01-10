<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('productPrice', 20, 2)->nullable();
            $table->decimal('billingAmount', 20, 2)->nullable();
            $table->decimal('amount_paid', 20, 2)->nullable();
            $table->decimal('billingbalance', 20, 2)->nullable();
            $table->integer('discount')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('created_by_id')->nullable();
            $table->string('user_type')->nullable();
            $table->integer('invoice_id')->nullable();
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
        Schema::dropIfExists('invoice_payments');
    }
}
