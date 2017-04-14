<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
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
        if($game->Players->count() >= 2) {
            // Guard against too many players
            return redirect('/')->with('errors', collect(['Too Many Players in That Game']));
        }
        
        $playerid = session('playerid', null);
        
        if(is_null($playerid)) {
            // Player is not already in session
            
            $color = $game->Players->count();
            
            $player = Player::create([
                'Color' => $color
            ]);
            
            $game->Players()->save($player);
            
            // Store new player in session
            session(['playerid' => $player->PlayerID]);
        }
        else
        {
            $player = Player::find($playerid);
        }
        
        $shots = $player->Shots();
        
        
        return view('game')->with([
            'game' => $game,
            'player' => $player,
            'shots' => $shots
        ]);
    }
    
}