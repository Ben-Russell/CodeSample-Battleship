<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ships', function (Blueprint $table) {
            
            $table->increments('ShipID');
            
            $table->string('Name');
            
            $table->integer('Length');
            
            $table->integer('Hits');
            
            $table->integer('StartX');
            $table->integer('StartY');
            
            $table->integer('EndX');
            $table->integer('EndY');
            
            $table->integer('PlayerID')
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
        Schema::dropIfExists('Ships');
    }
}
