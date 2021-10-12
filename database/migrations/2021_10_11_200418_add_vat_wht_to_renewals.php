<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVatWhtToRenewals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewals', function (Blueprint $table) {
            $table->string('value_added_tax')->nullable();
            $table->string('withholding_tax')->nullable();
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
            Schema::dropIfExists(['value_added_tax', 'withholding_tax']);
        });
    }
}
