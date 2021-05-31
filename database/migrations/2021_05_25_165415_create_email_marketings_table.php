<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_marketings', function (Blueprint $table) {
            $table->id();
            $table->integer('main_acct_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('user_type')->nullable();
            $table->text('subject')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('email_marketings');
    }
}
