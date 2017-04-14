<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{   
    protected $table = 'Ships';
    protected $primaryKey = 'ShipID';
    protected $guarded = [];
    
    public function AddHit() {
        // Make sure hits don't go over the length
        $this->Hits = min($this->Length, $this->Hits + 1);
    }
    
    public function IsDestroyed() {
        return $this->Hits >= $this->Length;
    }
}
