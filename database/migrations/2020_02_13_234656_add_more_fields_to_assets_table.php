<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('plan_id')->after('user_id')->nullable();
            $table->string('slot_plan_id')->after('plan_id')->nullable();
            $table->string('status')->after('slot_plan_id')->default('Not Occupied')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
             $table->integer('plan_id');
             $table->integer('slot_plan_id');
             $table->string('status');
        });
    }
}
