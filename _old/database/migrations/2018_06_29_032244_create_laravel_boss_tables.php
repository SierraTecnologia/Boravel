<?php

/*
 * This file is part of the ricardosierra/laravel-boss
 *
 * (c) ricardosierra <contato@ricardosierra.com.br>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelBossTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        /**
         * Boss Table
         */
        Schema::create(config('boss.tables.bossable.bossable_table', 'bossables'), function (Blueprint $table) {
            $userForeignKey = config('boss.tables.users.table_foreign_key', 'user_id');
            $table->unsignedInteger($userForeignKey);
            $table->unsignedInteger('bossable_id');
            $table->string('bossable_type')->index();
            $table->string('relation')->default('boss')->comment('boss/like/subscribe/favorite/upvote/downvote');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign($userForeignKey)
                ->references(config('boss.tables.users.table_primary_key', 'id'))
                ->on(config('boss.tables.users.table_name', 'users'))
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        /**
         * Messeges Table
         */
        Schema::create(config('boss.tables.messable.messable_table', 'messables'), function (Blueprint $table) {
            $userForeignKey = config('mess.tables.users.table_foreign_key', 'user_id');
            $table->unsignedInteger($userForeignKey);
            $table->unsignedInteger('messable_id');
            $table->string('messable_type')->index();
            $table->string('relation')->default('mess')->comment('mess/like/subscribe/favorite/upvote/downvote');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign($userForeignKey)
                ->references(config('boss.tables.users.table_primary_key', 'id'))
                ->on(config('boss.tables.users.table_name', 'users'))
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        Schema::create(config('boss.tables.bossable.bossable_table', 'bossables'), function (Blueprint $table) {
            $userForeignKey = config('boss.tables.users.table_foreign_key', 'user_id');
            $table->unsignedInteger($userForeignKey);
            $table->unsignedInteger('bossable_id');
            $table->string('bossable_type')->index();
            $table->string('relation')->default('boss')->comment('boss/like/subscribe/favorite/upvote/downvote');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign($userForeignKey)
                ->references(config('boss.tables.users.table_primary_key', 'id'))
                ->on(config('boss.tables.users.table_name', 'users'))
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table(config('boss.tables.bossable.bossable_table', 'bossables'), function ($table) {
            $table->dropForeign(config('boss.tables.bossable.bossable_table', 'bossables').'_user_id_foreign');
        });

        Schema::drop(config('boss.tables.bossable.bossable_table', 'bossables'));
    }
}
