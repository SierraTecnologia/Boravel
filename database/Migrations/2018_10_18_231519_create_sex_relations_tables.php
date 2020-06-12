<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSexRelationsTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        /**
         * Personagens
         */
		Schema::create('personagens', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->string('code')->unique();
            $table->primary('code');
			$table->string('name', 255)->nullable();
            $table->unsignedInteger('status')->default(0);
			$table->timestamps();
            $table->softDeletes();
		});
        
		Schema::create('personagenables', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('personagenable_id')->nullable();
			$table->string('personagenable_type', 255)->nullable();

            $table->string('personagen_code')->nullable();
            $table->foreign('personagen_code')->references('code')->on('personagens');
			$table->timestamps();
            $table->softDeletes();
        });
        


        /**
         * Gambles
         */
		Schema::create('gambles', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
            
			$table->integer('min_participantes')->nullable();
			$table->boolean('max_participantes')->nullable();
			$table->string('premio', '');
            
			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->timestamps();
            $table->softDeletes();
		});
		Schema::create('gamble_actions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
            $table->unsignedInteger('cupons');
            

			$table->unsignedInteger('gamble_id')->nullable();
			$table->foreign('gamble_id')->references('id')->on('gambles')->onDelete('set null');
			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
