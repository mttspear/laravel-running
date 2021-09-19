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
        //Get the users who are currently logged on
        $currentUsers = Users::getCurrentUsersWithNoPendingGame();
        $pendingGames = Users::getUsersPendingGames();
        $merged = $currentUsers->merge($pendingGames);
        //get any active game
        $activeGame = Game::getActiveGame();

        $gameScores = null;
        $gameScore = null;

        if ($activeGame->count() != 0) {
            $gameScores = GameScore::where("gameId", $activeGame->id)
                ->orderBy("updated_at", "desc")
                ->get()
                ->toJson();
            $gameScore = GameScore::getGameScore($activeGame->id)->toJson();

            $activeGame = $activeGame->toJson();
        } else {
            $activeGame = false;
        }

        //dd(\Carbon\Carbon::now());
        //dd($gameScores[0]->expired);
        return view("home", [
            "currentUsers" => $merged->toJson(),
            "activeGame" => $activeGame,
            "gameScores" => $gameScores,
            "gameScore" => $gameScore,
            //"user" => Auth::user(),
        ]);
    }
}
