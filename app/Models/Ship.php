<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{   
    protected $table = 'Ships';
    protected $primaryKey = 'ShipID';
    protected $guarded = [];
}
