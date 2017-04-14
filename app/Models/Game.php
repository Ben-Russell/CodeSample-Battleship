<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'Games';
    protected $primaryKey = 'GameID';
    protected $guarded = [];
}
