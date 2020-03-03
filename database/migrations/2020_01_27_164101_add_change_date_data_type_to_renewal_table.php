<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangeDateDataTypeToRenewalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewals', function (Blueprint $table) {
             if (Schema::hasColumn('renewals', 'start_date'))
            {
            Schema::table('renewals', function (Blueprint $table)
            {
               $table->dropColumn('start_date');
               $table->dropColumn('end_date');
            });
          }

            $table->date('start_date')->after('amount')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
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
            $table->date('start_date');
            $table->date('end_date');
        });
    }
}
