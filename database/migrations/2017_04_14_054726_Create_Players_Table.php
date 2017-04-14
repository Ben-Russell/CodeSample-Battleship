<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Players', function (Blueprint $table) {
            $table->increments('PlayerID');
            
            $table->tinyInteger('Color');
            
            $table->integer('GameID')
                ->default(0)
                ->unsigned();
            
            $table->foreign('GameID')
                ->references('GameID')
                ->on('Games')
                ->onDelete('cascade');
            
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
        Schema::dropIfExists('Players');
    }
}
