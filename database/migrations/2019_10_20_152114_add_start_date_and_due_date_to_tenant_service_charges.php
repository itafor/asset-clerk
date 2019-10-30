<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartDateAndDueDateToTenantServiceCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_service_charges', function (Blueprint $table) {
              $table->date('dueDate')->after('bal')->nullable(); 
             $table->date('startDate')->after('bal')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenant_service_charges', function (Blueprint $table) {
              $table->date('dueDate'); 
              $table->date('startDate'); 
        });
    }
}
