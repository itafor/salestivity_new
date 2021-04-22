<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPercentageToTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targets', function (Blueprint $table) {
             if (Schema::hasColumn('targets', 'percentage'))
            {
            Schema::table('targets', function (Blueprint $table)
            {
               $table->dropColumn('percentage');
            });
          }

            $table->decimal('percentage', 20, 2)->after('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('targets', function (Blueprint $table) {
            Schema::dropIfExists(['percentage']);
        });
    }
}
