<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameEquipamentsTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipaments', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create('acessorios', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create('vehicle_types', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->text('description')->nullable();
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
		Schema::drop('acessorios');
		Schema::drop('equipaments');
		Schema::drop('vehicle_types');
	}

}
