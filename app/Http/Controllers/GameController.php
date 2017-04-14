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
    
    public function play(Game $game)
    {
        $playerid = session('playerid', null);
        
        if(is_null($playerid)) {
            // Player is not already in session
            
            if($game->Players->count() >= 1) {
                // Guard against someone else trying to play the same game
                return redirect('/')->with('errors', collect(['Someone is already in that Game']));
            }
            
            $color = rand(0,1);
            
            $player = Player::create([
                'Color' => $color
            ]);
            
            $game->Players()->save($player);
            
            $player->SetupShips();
            
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