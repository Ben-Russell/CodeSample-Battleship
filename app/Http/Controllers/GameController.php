<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Shot;
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
            
            
            // Create the computer player
            $computer = Player::create([
                'Color' => ($color ? 0 : 1)
            ]);
            
            $game->Players()->save($computer);
            $computer->SetupShips();
            
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
    
    public function shoot(Request $request)
    {
        $playerid = session('playerid', null);
        
        if(is_null($playerid)) {
            // Guard against a player who hasn't been created, shooting
            return redirect('/')->with('errors', collect(['Please join a game before firing.']));
        }
        
        $player = Player::find($playerid);
        $game = Player->Game();
        $shots = $player->Shots();
        $computer = $game->Players()->where('color', ($player->Color ? 0 : 1))->get()->first();
        
        $this->validate(request, [
            'positionx' => 'integer|max:10|required',
            'positiony' => 'integer|max:10|required'
        ]);
        
        $positionx = request->input('positionx');
        $positiony = request->input('positiony');
        
        if($shots->where('PositionX', $positionx)->where('PositionY', $positiony)->get()->count()) {
            // Guard against firing in same location
            return redirect('/game/play/' . $game->GameID)->with('errors', collect(['You have already fired at that spot.']));
        }
        
        $result = $player->ShootAt($positionX, $positionY);
        
        $computerresult = ComputerTurnResult($game, $computer);
        
        
        return redirect('/game/play/' . $game-GameID)->with([
            'shotResult' => $result,
            'computerResult' => $computerresult
        ]);
    }
    
    private ComputerTurnResult($game, $computer) {
        $isnewshot = false;
        $shots = $computer->Shots();
        $failcount = 0;
        
        while(!$isnewshot && $failcount <= 50) {
            $positionx = rand(0, 9);
            $positiony = rand(0, 9);
            
            if(!$shots->where('PositionX', $positionx)->where('PositionY', $positiony)->get()->count())
            {
                $isnewshot = true;
            }
            else {
                $failcount++;
            }
            
        }
        
        if(!$isnewshot) {
            // We want to fail silently if computer can't find a shot in a reasonable time.
            return false;
        }
        
        return $computer->ShootAt($positionX, $positionY);

    }

}