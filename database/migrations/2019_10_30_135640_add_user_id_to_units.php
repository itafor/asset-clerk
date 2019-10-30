<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
             if (Schema::hasColumn('units', 'user_id'))
            {
            Schema::table('units', function (Blueprint $table)
            {
               $table->dropColumn('user_id');
            });
          }
             $table->integer('user_id')->after('category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->integer('user_id');
        });
    }
}
