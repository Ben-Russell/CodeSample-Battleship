<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Shots', function (Blueprint $table) {
            
            $table->increments('ShotsID');
            
            $table->integer('PositionX');
            
            $table->integer('PositionY');
            
            $table->boolean('IsHit')
                ->default(0);
            
            $table->integer('PlayerID')
                ->default(0)
                ->unsigned();
            
            $table->foreign('PlayerID')
                ->references('PlayerID')
                ->on('Players')
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
        Schema::dropIfExists('Shots');
    }
}
