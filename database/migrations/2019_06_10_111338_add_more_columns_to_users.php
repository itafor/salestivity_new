<?php

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// class AddMoreColumnsToUsers extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::table('users', function (Blueprint $table) {
//             $table->string('last_name')->after('name');
//             $table->integer('reports_to')->after('last_name')->unsigned();
//             $table->integer('status')->after('reports_to')->unsigned();
//             $table->integer('department_id')->after('status')->unsigned();
//             $table->integer('unit_id')->after('department_id')->unsigned();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::table('users', function (Blueprint $table) {
//             $table->dropColumn('last_name');
//             $table->dropColumn('reports_to');
//             $table->dropColumn('status');
//             $table->dropColumn('department_id');
//             $table->dropColumn('unit_id');
//         });
//     }
// }
