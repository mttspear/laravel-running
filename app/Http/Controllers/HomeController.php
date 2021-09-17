<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Users\Users;
use App\Models\Game;
use App\Models\GameScore;

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
        var_dump(Auth::user()->id);
        //Get the users who are currently logged on
        $currentUsers = Users::getCurrentUsersWithNoPendingGame();
        $pendingGames = Users::getUsersPendingGames();
        $merged = $currentUsers->merge($pendingGames);
        //get any active game
        $activeGame = Game::whereHas("gameScores", function ($query) {
            return $query
                ->where("playerId", "=", Auth::user()->id)
                ->where("status", "=", "active");
        })->first();
        $gameScores = GameScore::where("gameId", $activeGame->id)->get();
        return view("home", [
            "currentUsers" => $merged->toJson(),
            "activeGame" => $activeGame->toJson(),
            "gameScores" => $gameScores->toJson(),
        ]);
    }
}
