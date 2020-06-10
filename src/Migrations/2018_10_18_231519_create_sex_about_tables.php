<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSexAboutTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        
		Schema::create('genders', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->integer('status')->nullable();
			$table->unsignedInteger('gender_id')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
        
		Schema::create('relation_types', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->integer('status')->nullable();

			$table->unsignedInteger('relation_type_id')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
        
		Schema::create('positions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->string('code')->unique();
            $table->primary('code');
			$table->string('name', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->integer('status')->nullable();
			$table->string('position_code')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
        
		
		/**
		 * Relacoes
		 */
		Schema::create('relations', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->integer('status')->nullable();
			$table->string('bottom_code');
			$table->string('top_code');
			$table->string('name_relation_to')->nullable();
			$table->string('name_relation_from')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
		
		/**
		 * Estão Se relacionando
		 */
		Schema::create('relationables', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->date('date_init')->nullable();
			$table->date('date_response')->nullable();
			$table->date('date_end')->nullable();

			$table->unsignedInteger('betable_id');
			$table->string('betable_type', 255);
			$table->unsignedInteger('alphable_id');
			$table->string('alphable_type', 255);

            $table->unsignedInteger('relation_id')->nullable();
            // $table->foreign('relation_id')->references('id')->on('relations');
			$table->timestamps();
            $table->softDeletes();
        });



	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('identity_slaves');
	}

}
