<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateSubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop table if it exists
        Schema::dropIfExists('sub_users');

        // create this table
        Schema::create('sub_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->bigInteger('role_id')->nullable()->unsigned()->index();
            $table->bigInteger('reports_to')->nullable();
            // Specify if the user reports to a user in the users table or a user in the sub_users table
            $table->enum('reportsToCategory', ['users', 'sub_users'])->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->bigInteger('main_acct_id')->unsigned()->index();
            $table->string('password')->default(Hash::make('password'));
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Create Foreign key relationships
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('main_acct_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_users');
    }
}
