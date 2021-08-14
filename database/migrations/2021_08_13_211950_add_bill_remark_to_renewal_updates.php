<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillRemarkToRenewalUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewal_updates', function (Blueprint $table) {
            $table->string('bill_remark')->nullable();
            $table->date('bill_remark_payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renewal_updates', function (Blueprint $table) {
            Schema::dropIfExists(['bill_remark','bill_remark_payment_date']);
        });
    }
}
