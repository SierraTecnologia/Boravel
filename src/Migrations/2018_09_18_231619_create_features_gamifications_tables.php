<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesGamificationsTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('point_types', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
            $table->softDeletes();
        });
        
		Schema::create('points', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
            $table->string('text')->default('');
			$table->integer('position')->nullable();
			$table->integer('value')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
        
		Schema::create('pointables', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('pointable_id')->nullable();
			$table->string('pointable_type', 255)->nullable();
			$table->string('relation', 255)->nullable();

            $table->integer('point_id')->nullable();
            // $table->foreign('point_id')->references('id')->on('points');
			$table->timestamps();
            $table->softDeletes();
		});


		/**
		 * Undocumented function
		 *
		 * @return void
		 */
		Schema::create('coins', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
            $table->string('text')->default('');
			$table->integer('position')->nullable();
			$table->integer('value')->nullable();
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
		Schema::drop('pointables');
		Schema::drop('points');
		Schema::drop('point_types');
	}

}
