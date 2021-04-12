<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompEmailBankAcctToRenewals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewals', function (Blueprint $table) {
            $table->integer('company_email_id')->nullable();
            $table->integer('company_bank_acc_id')->nullable();
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
            Schema::dropIfExists(['company_email_id','company_bank_acc_id']);
        });
    }
}
