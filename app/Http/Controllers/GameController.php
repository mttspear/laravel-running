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

use App\Events\UserEvent;
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
        $game->requestor = $user->id;
        $game->save();
        //add players to the game
        $gameScore = new GameScore();
        $gameScore->playerId = $user->id;
        $gameScore->answerStatus = "pending";
        $gameScore->gameId = $game->id;
        $gameScore->save();

        $gameScoreSecondPlayer = new GameScore();
        $gameScoreSecondPlayer->playerId = (int) $request->input("id");
        $gameScoreSecondPlayer->answerStatus = "pending";
        $gameScoreSecondPlayer->gameId = $game->id;
        $gameScoreSecondPlayer->save();
        //if player has pending page or already in game return player busy message
        $currentUsers = Users::getCurrentUsersWithNoPendingGame();
        $pendingGames = Users::getUsersPendingGames();
        $merged = $currentUsers->merge($pendingGames);
        event(new UserEvent((int) $request->input("id"), $merged));
        //Create Event
        return response()->json([
            "currentUsers" => $merged->toJson(),
        ]);
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

        $gameScores = GameScore::GetGameScores($gameId)->toJson();
        $gameScore = GameScore::getGameScore($gameId)->toJson();
        $otherPlayer = GameScore::getOtherPlayer($gameId);
        $activeGame = Game::getActiveGame();
        $activeGame = $activeGame->toJson();

        return $this->gameResponse(
            $otherPlayer->playerId,
            $gameScore,
            $gameScores,
            null,
            $activeGame
        );
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
        $artistById = $discog->getArtistById($artistId);
        $artistName = $artistById["name"];
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
        $gameScore = GameScore::getGameScore($gameId)->toJson();
        $otherPlayer = GameScore::getOtherPlayer($gameId);
        return $this->gameResponse(
            $otherPlayer->playerId,
            $gameScore,
            $gameScores,
            $artistById
        );
    }

    public function submitSong(Request $request)
    {
        $user = Auth::user();
        $discog = new Discog();
        $data = $request->getContent();
        $data = json_decode($data, true);

        $gameId = (int) $data["gameId"];
        $song = $data["song"];

        $currentTurn = GameScore::getCurrentUserTurn($gameId);
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

        $gameScores = GameScore::GetGameScores($gameId)->toJson();
        $gameScore = GameScore::getGameScore($gameId)->toJson();

        Log::info(
            "gameControllerIsGameOver: " .
                print_r($gameHelper->isGameOver, true)
        );
        if ($gameHelper->isGameOver) {
            return $this->gameResponse(
                $gameHelper->otherPlayer->playerId,
                $gameScore,
                $gameScores,
                null,
                false
            );
        } else {
            //return the updated score

            //send score to other player
            Log::info("gameScores:" . print_r($gameScores, true));
            Log::info("gameScore:" . print_r($gameScore, true));
            return $this->gameResponse(
                $gameHelper->otherPlayer->playerId,
                $gameScore,
                $gameScores,
                null
            );
        }
    }

    public function test(Request $request)
    {
        GameScore::setGameOver(18);
        //dd($foo->playerId);
    }

    public function gameResponse(
        $playerId,
        $gameScore,
        $gameScores,
        $discogResults,
        $activeGame = null
    ) {
        event(
            new GameEvent(
                $playerId,
                $gameScore,
                $gameScores,
                $discogResults,
                $activeGame
            )
        );

        return response()->json([
            "gameScores" => $gameScores,
            "gameScore" => $gameScore,
            "artist" => $discogResults,
            "activeGame" => $activeGame,
        ]);
    }
}
