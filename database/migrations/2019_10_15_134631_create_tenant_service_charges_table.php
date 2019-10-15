<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantServiceChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_service_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tenant_id');
            $table->integer('asc_id');
            $table->integer('service_chargeId');
            $table->integer('user_id');
            $table->integer('bal');
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
        Schema::dropIfExists('tenant_service_charges');
    }
}
