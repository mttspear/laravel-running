<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_score', function (Blueprint $table) {
            $table->id();

            $table->string('artistID')->nullable();
            $table->string('artistName')->nullable();
            $table->string('playerAnswer')->nullable();
            $table->string('answerStatus')->default(0)->nullable();
            
            $table->unsignedBigInteger('playerId');
            $table->unsignedBigInteger('gameId');
            $table->index('playerId');
            $table->index('gameId');
            $table->foreign('playerId')->references('id')->on('users');
            $table->foreign('gameId')->references('id')->on('game');
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
        Schema::dropIfExists('game_score');
    }
}
