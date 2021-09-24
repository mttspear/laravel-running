<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Helpers\Users\Users;
use App\Helpers\Discog\Discog;
use App\Helpers\Game\GameHelper;

use App\Models\Game;
use App\Models\GameScore;

use App\Events\NewMessage;
use App\Events\GameEvent;

class GameController extends Controller
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
     * Start a new game
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
        $data = $request->getContent();
        $data = json_decode($data, true);
        $artist = $data["artist"];
        $discog = new Discog();
        $discogResults = $discog->getArtistFromSearch($artist);
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
        $artistId = $data["artist"];
        $gameId = (int) $data["gameId"];
        //update game score table will need to null
        $discog = new Discog();
        $discogResults = $discog->getArtistById($artistId);
        $artistName = $discogResults["name"];

        //Update player who ansered
        GameScore::setCurrentPlayerStatus(
            $gameId,
            $user->id,
            "wait-turn",
            null,
            $artistId,
            $artistName
        );

        //update waiting player
        GameScore::setOtherPlayerStatus(
            $gameId,
            $user->id,
            "player-turn",
            null,
            $artistId,
            $artistName
        );

        $gameScores = GameScore::GetGameScores($gameId)->toJson();

        return response()->json([
            "gameScores" => $gameScores,
            "gameScore" => GameScore::getGameScore($gameId)->toJson(),
        ]);
    }

    public function submitSong(Request $request)
    {
        $user = Auth::user();
        $discog = new Discog();
        $data = $request->getContent();
        $data = json_decode($data, true);

        $gameId = (int) $data["gameId"];
        $song = $data["song"];

        $currentTurn = GameScore::getCurrentTurn($gameId);
        // if the players turn is not up exit
        if ($currentTurn->count() == 0) {
            return response()->json(["message" => "not your turn"]);
        }

        $artistId = $currentTurn->artistID;
        $artistName = $currentTurn->artistName;
        $discogResults = $discog->getSong($song, $artistName);

        $gameHelper = new GameHelper(
            $discogResults,
            $artistId,
            $artistName,
            $song,
            $gameId
        );

        $gameHelper->scoreAnswer();

        //update other player
        $gameHelper->setNextMove();

        //return the updated score
        $gameScores = GameScore::GetGameScores($gameId)->toJson();
        $gameScore = GameScore::getGameScore($gameId)->toJson();

        //send score to other player
        Log::info("otherPlayer:" . print_r($gameHelper->otherPlayer, true));
        event(
            new GameEvent(
                $gameHelper->otherPlayer->playerId,
                $gameScore,
                $gameScores
            )
        );

        return response()->json([
            "gameScores" => $gameScores,
            "gameScore" => $gameHelper->score->toJson(),
        ]);
    }

    public function test(Request $request)
    {
        //event(new NewMessage("hello world"));
        $user = Auth::user();
        $gameScores = GameScore::GetGameScores(20)->toJson();
        $gameScore = GameScore::getGameScore(20)->toJson();
        event(new GameEvent(1, $gameScore, $gameScores));
        dd("hello");
    }
}
