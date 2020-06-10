<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyser_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('md5_name');
            $table->string('result');
            $table->string('md5_result');
            $table->integer('status');
            $table->string('reference_id')->nullable();
            $table->string('bot_runner_id');
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
        Schema::dropIfExists('analyser_results');
    }
}
