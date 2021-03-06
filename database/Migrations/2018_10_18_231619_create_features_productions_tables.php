<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesProductionsTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Producoes
		 */
		Schema::create(config('app.db-prefix', '').'productions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->integer('ano')->nullable();
			$table->integer('girls')->nullable();
			$table->integer('boys')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
        
		Schema::create(config('app.db-prefix', '').'productionables', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('production_id')->nullable();
			$table->string('productionable_id')->nullable();
			$table->string('productionable_type', 255)->nullable();
			$table->timestamps();
            $table->softDeletes();
		});



		/**
		 * Resto
		 */
		Schema::create(config('app.db-prefix', '').'production_variables', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_actions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_action_ocorrences', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_action_types', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_actors', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_characters', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_character_clothings', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_clothings', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_clothing_types', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_items', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_rpg', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_scenes', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_scene_lines', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_scene_locals', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create(config('app.db-prefix', '').'production_scene_stages', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			// $table->string('business_code');
            // $table->foreign('business_code')->references('code')->on('businesses');
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
		Schema::dropIfExists('production_variables');
	}

}
