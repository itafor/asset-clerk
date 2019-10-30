<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    public function up()
    {
        Schema::create('rent_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('tenant_uuid')->nullable();
            $table->string('tenantRent_uuid')->nullable();
            $table->string('asset_uuid')->nullable();
            $table->string('unit_uuid')->nullable();
            $table->integer('proposed_amount')->nullable();
            $table->integer('actual_amount')->nullable();
            $table->integer('amount_paid')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('payment_mode_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('startDate')->nullable();
            $table->string('due_date')->nullable();
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
        Schema::dropIfExists('rent_payments');
    }
}
