<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function create(Request $request)
    {
        $game = Game::create();
        
        return redirect('game/play/' . $game->GameID);
    }
    
    public function join(Request $request)
    {
        $gameid = $request->input('GameID');
        
        $game = Game::find($gameid);
        
        return redirect('game/play/' . $game->GameID);
    }
    
    public function play(Game $game)
    {
        return view('game')->with('game', $game);
    }
    
}