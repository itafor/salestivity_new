<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullFieldsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
                if (Schema::hasColumn('contacts', 'customer_id'))
            {
            Schema::table('contacts', function (Blueprint $table)
            {
               $table->dropColumn('customer_id');
               $table->dropColumn('title');
               $table->dropColumn('surname');
               $table->dropColumn('name');
               $table->dropColumn('phone');
               $table->dropColumn('email');
               $table->dropColumn('main_acct_id');
            });
          }
            $table->integer('customer_id')->after('id')->nullable();
            $table->string('title')->after('customer_id')->nullable();
            $table->string('surname')->after('title')->nullable();
            $table->string('name')->after('surname')->nullable();
            $table->string('phone')->after('name')->nullable();
            $table->string('email')->after('phone')->nullable();
            $table->integer('main_acct_id')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('customer_id');
            $table->string('title');
            $table->string('surname');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->integer('main_acct_id');
        });
    }
}
