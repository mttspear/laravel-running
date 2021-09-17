<?php

namespace App\Helpers\Game;

use Illuminate\Support\Facades\Auth;

use App\Models\GameScore;

use Illuminate\Support\Facades\Http;

class GameHelper
{
    public $duplicateCheckPercent = 50.0;
    public $similarCheckPercent = 75.0;

    public $response;
    public $artistId;
    public $guess;
    public $gameId;

    public function __construct($response, $artistId, $artist, $guess, $gameId)
    {
        $this->response = $response;
        $this->artistId = $artistId;
        $this->artist = $artist;
        $this->guess = $guess;
        $this->gameId = $gameId;
    }

    /**
     * Check the answer to make sure there is a match or artist, song, and the guess was not used before
     */
    public function checkAnswer()
    {
        //check artist
        $checkArtist = $this->checkArtist();
        \Log::info($checkArtist ? "checkArtist:true" : "checkArtist:false");
        if (!$checkArtist) {
            return false;
        }
        //check track
        $checkTrack = $this->checkTracks(
            $this->response["tracklist"],
            $this->guess
        );
        if (!$checkTrack) {
            return false;
        }

        $previousGuesses = GameScore::where("artistID", $this->artistId)
            ->where("gameId", $this->gameId)
            ->get();

        //check match percent
        return true;
    }

    /**
     * Check to make sure the artist returned matches the guess
     */
    public function checkArtist()
    {
        foreach ($this->response["artists"] as $item) {
            if ($item["id"] == (int) $this->artistId) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check to see if the track is on the returned track list
     */
    public function checkTracks()
    {
        foreach ($this->response["tracklist"] as $item) {
            $checkPercent = similar_text(
                strtolower($item["title"]),
                strtolower($this->guess),
                $perc
            );
            \Log::info(
                "guess:" .
                    $this->guess .
                    " song:" .
                    $item["title"] .
                    " percent:" .
                    $perc
            );
            if ($perc >= $this->similarCheckPercent) {
                return true;
            }
        }
        return false;
    }

    public function scoreAnswer()
    {
        $answerCheck = $this->checkAnswer();
        //If test is true score a point
        if ($answerCheck) {
            $answerStatus = "correct";
        }
        //if the test is false incorrect
        else {
            $answerStatus = "incorrect";
        }
        dd($answerStatus);
        //update player who guessed
        GameScore::where("gameId", $gameId)
            ->where("playerId", "=", $user->id)
            ->where("artistID", "=", $artistId)
            ->where("answerStatus", "=", "player-turn")
            ->update([
                "answerStatus" => $answerStatus,
                "playerAnswer" => $song,
            ]);
    }

    public function setNextMove()
    {
        $user = Auth::user();
        //If score is at limit game is over
        $score = $this->getGameScore();
        //if other player is incorrect new artist needed
        $previousIncorrect = GameScore::where("artistID", $this->artistId)
            ->where("gameId", $this->gameId)
            ->where("playerId", "!=", $user->id)
            ->where("answerStatus", "=", "incorrect")
            ->get();

        //dd($previousIncorrect);
        //if empty set new artist status
        if (!$previousIncorrect->isEmpty()) {
            dd("empty");
        } else {
            GameScore::where("gameId", $this->gameId)
                ->where("playerId", "!=", $user->id)
                ->where("artistID", "=", $this->artistId)
                ->where("answerStatus", "=", "wait-turn")
                ->update([
                    "answerStatus" => "player-turn",
                ]);
            //create record for next move
            $gameScore = new GameScore();
            $gameScore->playerId = $user->id;
            $gameScore->answerStatus = "wait-turn";
            $gameScore->gameId = $this->gameId;
            $gameScore->artistID = $this->artistId;
            $gameScore->artistName = $this->artist;
            $gameScore->save();
        }
    }

    public function getGameScore()
    {
        $gameScore = \DB::table("game_score")
            ->select("playerId", \DB::raw("count(*) as score"))
            ->where("gameId", "=", $this->gameId)
            ->where("answerStatus", "=", "correct")
            ->groupBy("playerId")
            ->get();

        return $gameScore;
    }
}
