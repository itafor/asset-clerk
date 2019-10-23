<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_debtors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('tenant_uuid')->nullable();
            $table->string('tenantRent_uuid')->nullable();
            $table->string('asset_uuid')->nullable();
            $table->string('unit_uuid')->nullable();
            $table->integer('proposed_price')->nullable();
            $table->integer('actual_amount')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('duration')->nullable();
            $table->date('startDate')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('rent_debtors');
    }
}
