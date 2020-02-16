<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
                 if (Schema::hasColumn('customers', 'account_id'))
            {
            Schema::table('customers', function (Blueprint $table)
            {
               $table->dropColumn('account_id');
               $table->dropColumn('account_type');
            });
          }

            $table->string('industry')->after('name')->nullable();
            $table->string('phone')->after('industry')->nullable();
            $table->string('website')->after('phone')->nullable();
            $table->string('turn_over')->after('website')->nullable();
            $table->string('employee_count')->after('turn_over')->nullable();
            $table->string('office_address')->after('employee_count')->nullable();
            $table->string('home_address')->after('office_address')->nullable();
            $table->string('customer_type')->after('home_address')->nullable();
            $table->integer('account_id')->after('customer_type')->nullable();
            $table->integer('account_type')->after('account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
             $table->string('industry');
             $table->string('phone');
             $table->string('website');
             $table->string('turn_over');
             $table->string('employee_count');
             $table->string('office_address');
             $table->string('home_address');
             $table->string('customer_type');
             $table->integer('account_id');
             $table->integer('account_type');
        });
    }
}
