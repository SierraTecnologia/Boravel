<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlavePlaceAndEventsTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        
        
		Schema::create('places', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->timestamps();
            $table->softDeletes();
		});
        
		Schema::create('placeables', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('placeable_id');
			$table->string('placeable_type', 255);

            $table->unsignedInteger('place_id')->nullable();
            // $table->foreign('place_id')->references('id')->on('places');
			$table->timestamps();
            $table->softDeletes();
		});
        

        Schema::create(config('app.db-prefix', '').'events', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('title');
            $table->text('details');
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->boolean('is_published')->default(0);
            $table->string('template')->default('show');
            $table->dateTime('published_at')->nullable();
            $table->text('blocks')->nullable();
            $table->nullableTimestamps();
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
		Schema::drop('places');
	}

}
