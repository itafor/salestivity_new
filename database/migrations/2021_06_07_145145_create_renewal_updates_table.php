<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewalUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_updates', function (Blueprint $table) {
            $table->id();
            $table->integer('renewal_id')->nullable();
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
        Schema::dropIfExists('renewal_updates');
    }
}
