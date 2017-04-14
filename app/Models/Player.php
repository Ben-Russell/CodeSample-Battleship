<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{   
    protected $table = 'Players';
    protected $primaryKey = 'PlayerID';
    protected $guarded = [];
    
    public function Shots() {
        return $this->hasMany('App\Models\Shot', 'PlayerID');
    }
}
