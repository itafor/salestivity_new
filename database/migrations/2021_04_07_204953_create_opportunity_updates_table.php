<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunityUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('opportunity_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->date('update_date')->nullable();
            $table->string('type')->nullable();
            $table->text('commments')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('opportunity_updates');
    }
}
