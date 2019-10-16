<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tenant_id');
            $table->integer('user_id');
            $table->integer('previous_balance');
            $table->integer('new_balance');
            $table->integer('amount');
            $table->string('transaction_type');
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
        Schema::dropIfExists('wallet_histories');
    }
}
