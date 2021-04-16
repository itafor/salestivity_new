<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunityUpdateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_update_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('opportunity_update_id')->nullable();
            $table->integer('opportunity_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('reply')->nullable();
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
        Schema::dropIfExists('opportunity_update_replies');
    }
}
