<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDepartmentIdAndUnitIdFromSubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_users', function (Blueprint $table) {
                  if (Schema::hasColumn('sub_users', 'department_id'))
            {
            Schema::table('sub_users', function (Blueprint $table)
            {
               $table->dropColumn('department_id');
               $table->dropColumn('unit_id');
            });
        }
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
            Schema::dropIfExists('department_id');
            Schema::dropIfExists('unit_id');
        });
    }
}
