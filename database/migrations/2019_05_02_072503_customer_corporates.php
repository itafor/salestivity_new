<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerCorporates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_corporates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('industry');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('email');
            $table->string('turn_over');
            $table->string('employee_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_corporates');
    }
}
