<?php

namespace App\Models;

use App\Models\Ship;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{   
    protected $table = 'Players';
    protected $primaryKey = 'PlayerID';
    protected $guarded = [];
    
    public function Ships() {
        return $this->hasMany('App\Models\Ship', 'PlayerID');    
    }
    
    public function Shots() {
        return $this->hasMany('App\Models\Shot', 'PlayerID');
    }
    
    
    public function SetupShips() {
        
        if($this->Color) {
            // Red Player
            $ship = Ship::create([
                'Name' => 'BattleShip',
                'Length' => 4,
                'StartX' => 0,
                'StartY' => 0,
                'EndX' => 0,
                'EndY' => 3
            ]);
            $this->Ships()->save($ship);
            
            $ship = Ship::create([
                'Name' => 'Cruiser',
                'Length' => 3,
                'StartX' => 9,
                'StartY' => 9,
                'EndX' => 9,
                'EndY' => 7
            ]);
            $this->Ships()->save($ship);
            
            $ship = Ship::create([
                'Name' => 'Carrier',
                'Length' => 5,
                'StartX' => 4,
                'StartY' => 8,
                'EndX' => 4,
                'EndY' => 4
            ]);
            $this->Ships()->save($ship);
            
        }
        else {
            // Blue Player
            
            $ship = Ship::create([
                'Name' => 'BattleShip',
                'Length' => 4,
                'StartX' => 9,
                'StartY' => 0,
                'EndX' => 9,
                'EndY' => 3
            ]);
            $this->Ships()->save($ship);
            
            $ship = Ship::create([
                'Name' => 'Cruiser',
                'Length' => 3,
                'StartX' => 0,
                'StartY' => 9,
                'EndX' => 0,
                'EndY' => 7
            ]);
            $this->Ships()->save($ship);
            
            $ship = Ship::create([
                'Name' => 'Carrier',
                'Length' => 5,
                'StartX' => 8,
                'StartY' => 2,
                'EndX' => 4,
                'EndY' => 2
            ]);
            $this->Ships()->save($ship);
            
        }
        
    }
}
