<?php

namespace App\Models;

use App\Models\Ship;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{   
    protected $table = 'Players';
    protected $primaryKey = 'PlayerID';
    protected $guarded = [];
    
    public function Game() {
        return $this->belongsTo('App\Models\Game', 'PlayerID');    
    }
    
    public function Ships() {
        return $this->hasMany('App\Models\Ship', 'PlayerID');    
    }
    
    public function Shots() {
        return $this->hasMany('App\Models\Shot', 'PlayerID');
    }
    
    public function CheckIfHit($x, $y) {
        $ishit = false;
        $ships = $this->Ships();
        
        $ships->each(function($ship) use(&$ishit) {
            // Some math to check if the shot point is in the ship
            
            $shipxmin = min($ship->StartX, $ship->EndX);
            $shipxmax = max($ship->StartX, $ship->EndX);
            
            $shipymax = min($ship->StartY, $ship->EndY);
            $shipymax = max($ship->StartY, $ship->EndY);
            
            if(
                $shipxmin <= $x && $x <= $shipxmax &&
                $shipymin <= $y && $y <= $shipymax
              )
            {
                $ishit = true;
                $ship->AddHit();
                
                return false; // This will break the each loop early
            }
            
        });
        
        return $ishit;
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
    
    public function ShootAt($x, $y) {
        $ishit = $this->CheckIfHit($positionx, $positiony);

        $shot = Shot::create([
            'PositionX' => $positionx,
            'PositionY' => $positiony,
            'IsHit' => $ishit
        ]);
        
        $this->Shots($shot)->save();
        
        return $ishit;
    }
}
