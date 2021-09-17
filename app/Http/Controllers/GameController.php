<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Users\Users;
use App\Helpers\Discog\Discog;
use App\Helpers\Game\GameHelper;

use App\Models\Game;
use App\Models\GameScore;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createGame(Request $request)
    {
        $user = Auth::user();
        //Create new game
        $game = new Game();
        $game->status = "pending";
        $game->save();
        //add players to the game
        $gameScore = new GameScore();
        $gameScore->playerId = $user->id;
        $gameScore->answerStatus = "pending";
        $gameScore->gameId = $game->id;
        $gameScore->save();

        $gameScoreSecondPlayer = new GameScore();
        $gameScoreSecondPlayer->playerId = $request->input("id");
        $gameScoreSecondPlayer->answerStatus = "pending";
        $gameScoreSecondPlayer->gameId = $game->id;
        $gameScoreSecondPlayer->save();
        //if player has pending page or already in game return player busy message
        return ["status" => "Game Created"];
    }

    public function startGame(Request $request)
    {
        $user = Auth::user();

        $gameId = $request->input("id");
        $game = Game::find($gameId);
        $game->status = "active";
        $game->save();

        GameScore::where("gameId", $gameId)
            ->where("playerId", $user->id)
            ->update(["answerStatus" => "pick-artist"]);

        GameScore::where("gameId", $gameId)
            ->where("playerId", "!=", $user->id)
            ->update(["answerStatus" => "wait-turn"]);
        return ["status" => $gameId];
    }

    public function submitArtist(Request $request)
    {
        $user = Auth::user();
        $data = $request->getContent();
        $data = json_decode($data, true);
        $artist = $data["artist"];
        $discog = new Discog();
        $discogResults = $discog->getArtist($artist);
        return $discogResults;
    }

    /**
     * The user confirms the artist to be used.
     * Once the artist is selected the game score table is updated.
     * The person who
     */
    public function confirmArtist(Request $request)
    {
        $user = Auth::user();
        $data = $request->getContent();
        $data = json_decode($data, true);
        $artist = $data["artist"];
        $gameId = (int) $data["gameId"];
        //update game score table will need to null
        GameScore::where("gameId", $gameId)
            ->where("playerId", $user->id)
            ->whereNull("playerAnswer")
            ->update([
                "answerStatus" => "wait-turn",
                "artistID" => $artist,
            ]);

        GameScore::where("gameId", $gameId)
            ->where("playerId", "!=", $user->id)
            ->whereNull("playerAnswer")
            ->update([
                "answerStatus" => "player-turn",
                "artistID" => $artist,
            ]);
    }

    public function submitSong(Request $request)
    {
        $user = Auth::user();
        $discog = new Discog();
        $data = $request->getContent();
        $data = json_decode($data, true);

        //$gameId = $data["gameId"];
        //$song = $data["song"];
        $gameId = 18;
        $song = "shine on you crazy diamond";
        $artistId = 45467;
        $artist = "pink floyd";

        $discogResults = $discog->getSong($song, $artist);

        $gameHelper = new GameHelper(
            $discogResults,
            $artistId,
            $artist,
            $song,
            $gameId
        );

        $gameHelper->scoreAnswer();

        //update other player
        $gameHelper->setNextMove();
        dd("done");
    }
}
