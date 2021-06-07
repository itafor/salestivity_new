<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewalUpdateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_update_replies', function (Blueprint $table) {
            $table->id();
            $table->integer('renewal_update_id')->nullable();
            $table->integer('renewal_id')->nullable();
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
        Schema::dropIfExists('renewal_update_replies');
    }
}
