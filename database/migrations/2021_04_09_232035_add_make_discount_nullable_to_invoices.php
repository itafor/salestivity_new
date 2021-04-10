<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMakeDiscountNullableToInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
          if (Schema::hasColumn('invoices', 'discount'))
            {
            Schema::table('invoices', function (Blueprint $table)
            {
               $table->dropColumn('discount');
            });
        }
            $table->string('discount')->after('billingAmount')->nullable();

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
              $table->integer('discount');
        });
    }
}
