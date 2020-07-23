<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_users', function (Blueprint $table) {
            $table->string('user_type')->nullable()->after('main_acct_id');
            $table->integer('created_by')->nullable()->after('user_type');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_users', function (Blueprint $table) {
            $table->dropColumn('user_type');
            $table->dropColumn('created_by');
        });
    }
}
