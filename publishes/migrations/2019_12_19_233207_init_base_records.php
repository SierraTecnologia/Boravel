<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitBaseRecords extends Migration
{
       
    protected static function getDataClasses()
    {
        return array_merge(
            \Data\Informacao\Informacao::getDataClasses(),
            \Data\Libertario\Libertario::getDataClasses(),
            \Data\Treinamento\Treinamento::getDataClasses(),
        );
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'rrs', function (Blueprint $table) {

                // Set the storage engine and primary key
                $table->engine = 'InnoDB';
                $table->increments('id');

                // Ordinary columns
                $table->string('name')->nullable();
                $table->string('content')->nullable();
                $table->string('url')->nullable();
                $table->string('service_id')->nullable();

                // Automatic columns
                $table->timestamps();
            }
        );

        Schema::create(
            'articles', function (Blueprint $table) {

                // Set the storage engine and primary key
                $table->engine = 'InnoDB';
                $table->increments('id');
            
                $table->string('name')->nullable();
                $table->string('content')->nullable();

                // Automatic columns
                $table->timestamps();
            }
        );
        Schema::create(
            'estatisticas', function (Blueprint $table) {

                // Set the storage engine and primary key
                $table->engine = 'InnoDB';
                $table->increments('id');
            
                $table->string('fonte')->nullable();
                $table->string('nome')->nullable();
                $table->string('periodo')->nullable();
                $table->string('date')->nullable();
            
                $table->string('result')->nullable();


                $table->json('extra_type')->nullable();

                // Automatic columns
                $table->timestamps();
            }
        );


        collect(
            self::getDataClasses()
        )->map(
            function ($class) {
                (new $class)->run();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('rrs');
    }
}
