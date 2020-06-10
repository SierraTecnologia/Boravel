<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBossControlVendasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('value');
            $table->string('paymentable_id')->nullable();
            $table->string('paymentable_type')->nullable();
            $table->string('targetable_id')->nullable();
            $table->string('targetable_type')->nullable();
            $table->timestamps();
        });


        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
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
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_types');
    }
}
