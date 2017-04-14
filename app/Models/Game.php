<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'Games';
    protected $primaryKey = 'GameID';
    protected $guarded = [];
    
    public function Players()
    {
        return $this->hasMany('App\Models\Player', 'GameID');
    }
    
    public function GetOtherPlayer($player)
    {
        return $this->Players()->where('color', ($player->Color ? 0 : 1))->get()->first();
    }
    
    public function IsOver()
    {
        $isover = false;
        
        $players = $this->Players();
        
        $players->each(function($player) use(&$isover) {
            if($player->IsDead()) {
                $isover = true;
                return false; // break each loop
            }
        });
        
        return $isover;
    }
}
