<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Users\Users;
use App\Models\Game;
use App\Models\GameScore;
use App\Helpers\Discog\Discog;

use App\Events\NewGame;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //save a session that indicates currently logged on
        Session(["key" => "value"]);
        Session()->save();
        //Get the users who are currently logged on
        $currentUsers = Users::getCurrentUsersWithNoPendingGame();

        $pendingGames = Users::getUsersPendingGames();

        $merged = $currentUsers->merge($pendingGames);

        //get previous games
        $inActiveGames = Game::getInactiveGames()->toJson();
        //dd($inActiveGames);

        //get active game
        $activeGame = Game::getActiveGame();
        $gameScores = null;
        $gameScore = null;
        $artistById = null;

        if ($activeGame->count() != 0) {
            $gameScores = GameScore::GetGameScores($activeGame->id)->toJson();
            $gameScore = GameScore::getGameScore($activeGame->id)->toJson();
            $currentTurn = GameScore::getCurrentTurn($activeGame->id);
            $discog = new Discog();
            if (!is_null($currentTurn->artistID)) {
                $artistById = $discog->getArtistById($currentTurn->artistID);
            }

            $activeGame = $activeGame->toJson();
        } else {
            $activeGame = false;
        }

        return view("home", [
            "currentUsers" => $merged->toJson(),
            "activeGame" => $activeGame,
            "inActiveGames" => $inActiveGames,
            "gameScores" => $gameScores,
            "gameScore" => $gameScore,
            "artist" => $artistById,
        ]);
    }
}
