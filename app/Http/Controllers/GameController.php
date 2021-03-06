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
        
        // Create a new player session
        session(['playerid' => null]);
        
        return redirect('game/play/' . $game->GameID);
    }
    
    public function end()
    {
        return view('end');
    }
    
    public function index()
    {
        return view('index');
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
        
        $isover = $game->IsOver();
        
        if($isover) {
            $playerdead = $player->IsDead();
            $game->delete();
            return redirect('/game/end')->with('result', ($playerdead ? '' : 'win'));
        }

        $shots = $player->Shots()->get();
        
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
        $game = $player->Game()->first();
        $shots = $player->Shots();
        $computer = $game->GetOtherPlayer($player);
        
        $this->validate($request, [
            'positionx' => 'integer|max:10|required',
            'positiony' => 'integer|max:10|required'
        ]);
        
        $positionx = $request->input('positionx');
        $positiony = $request->input('positiony');
        
        if($shots->where('PositionX', $positionx)->where('PositionY', $positiony)->get()->count()) {
            // Guard against firing in same location
            return redirect('/game/play/' . $game->GameID)->with('errors', collect(['You have already fired at that spot.']));
        }
        
        $result = $player->ShootAt($computer, $positionx, $positiony);
        
        $computerresult = $this->ComputerTurnResult($game, $computer, $player);
        
        return redirect('/game/play/' . $game->GameID)->with([
            'shotResult' => ($result ? 'hit' : 'miss'),
            'computerResult' => ($computerresult ? 'hit' : 'miss')
        ]);
    }
    
    private function ComputerTurnResult($game, $computer, $player) {
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
        
        return $computer->ShootAt($player, $positionx, $positiony);

    }

}