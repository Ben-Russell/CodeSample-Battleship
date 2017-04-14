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
            $table->increments('PlayerID')
				->unique()
				->primary()
				->unsigned();
            
            $table->string('Name', 50);
            
            $table->tinyInteger('Color');
            
            $table->integer('GameID')
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
