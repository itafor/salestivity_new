<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('name');
            $table->string('company_name')->after('last_name')->nullable();
            $table->string('phone')->after('company_name')->nullable();
            $table->string('subdomain')->after('phone')->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('reports_to')->unsigned()->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->integer('profile_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('company_name');
            $table->dropColumn('phone');
            $table->dropColumn('subdomain');
            $table->dropColumn('role_id');
            $table->dropColumn('reports_to');
            $table->dropColumn('status');
            $table->dropColumn('department_id');
            $table->dropColumn('unit_id');
            $table->dropColumn('profile_id');
        });
    }
}
