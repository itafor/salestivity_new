<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerIdToOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opportunities', function (Blueprint $table) {
          if (Schema::hasColumn('opportunities', 'owner'))
            {
            Schema::table('opportunities', function (Blueprint $table)
            {
               $table->dropColumn('owner');
               $table->dropColumn('stage');
               $table->dropColumn('amount');
               $table->dropColumn('contact');
            });
        }

            $table->integer('owner_id')->after('account_id')->nullable();  
            $table->string('stage')->after('status')->nullable();  
            $table->decimal('amount',20,2)->after('name')->nullable();
            $table->integer('contact_id')->after('main_acct_id')->nullable();  

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opportunities', function (Blueprint $table) {
             Schema::dropIfExists('owner_id');
             Schema::dropIfExists('stage');
             Schema::dropIfExists('amount');
             Schema::dropIfExists('contact_id');
        });
    }
}
