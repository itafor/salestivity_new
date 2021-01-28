<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalReminderDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_reminder_durations', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->integer('renewal_id')->nullable(); 
             $table->integer('first_duration')->nullable(); 
             $table->integer('second_duration')->nullable(); 
             $table->integer('third_duration')->nullable(); 
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
        Schema::dropIfExists('renewal_reminder_durations');
    }
}
