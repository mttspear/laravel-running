<?php

namespace App\Helpers\Game;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Game;
use App\Models\GameScore;

class GameHelper
{
    public $duplicateCheckPercent = 50.0;
    public $similarCheckPercent = 55.0;

    public $response;
    public $isGameOver;
    public $artistId;
    public $artistName;
    public $guess;
    public $gameId;
    public $answerStatus;
    public $score;
    public $otherPlayer;

    public function __construct(
        $response,
        $artistId,
        $artistName,
        $guess,
        $gameId
    ) {
        $this->response = $response;
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->guess = $guess;
        $this->gameId = $gameId;
        $this->score = GameScore::getGameScore($this->gameId);
        $this->setOtherPlayer();
    }

    /**
     * Check the answer to make sure there is a match or artist, song, and the guess was not used before
     */
    public function checkAnswer()
    {
        //check artist
        $checkArtist = $this->checkArtist();
        Log::info($checkArtist ? "checkArtist:true" : "checkArtist:false");
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

        foreach ($previousGuesses as $item) {
            similar_text(
                strtolower($item["playerAnswer"]),
                strtolower($this->guess),
                $perc
            );
            if ($perc >= $this->duplicateCheckPercent) {
                return false;
            }
        }

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
            Log::info(
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

    /**
     * Update the game score table to reflect correct/incorrect answers
     */
    public function scoreAnswer()
    {
        $user = Auth::user();
        $answerCheck = $this->checkAnswer();
        //If test is true score a point
        if ($answerCheck) {
            $this->answerStatus = "correct";
        }
        //if the test is false incorrect
        else {
            $this->answerStatus = "incorrect";
        }

        //update player who guessed
        GameScore::setCurrentPlayerStatus(
            $this->gameId,
            $user->id,
            $this->answerStatus,
            $this->guess,
            $this->artistId,
            $this->artistName
        );
    }

    /**
     *Set the next move based on game score and previous guesses.
     */
    public function setNextMove()
    {
        $user = Auth::user();
        //If score is at limit game is over
        $this->score = GameScore::getGameScore($this->gameId); //update the score
        $game = Game::find($this->gameId);
        foreach ($this->score as $item) {
            if ($item["score"] >= $game->scoreLimit) {
                //set game as over
                Game::setGameOver($this->gameId);
                //set game score to over
                GameScore::setGameOver($this->gameId);
                $this->isGameOver = true;
            }
        }
        // if the game is not over set the next move
        if (!$this->isGameOver) {
            //if other player is incorrect new artist needed
            $gameScore = new GameScore();
            $gameScore->playerId = $user->id;
            $gameScore->gameId = $this->gameId;
            Log::info(
                "gameHelperOtherPlayerAnswerStatus: " .
                    $this->otherPlayer["answerStatus"]
            );
            //if the players answer is incorrect and the other players status is not pick artist
            if (
                $this->answerStatus == "incorrect" &&
                $this->otherPlayer["answerStatus"] != "pick-artist"
            ) {
                //if incorrect player will choose the next artist
                $gameScore->answerStatus = "pick-artist";
            }
            // if player incorrect and other is picking the artist use wait turn and null the artist
            elseif (
                $this->answerStatus == "incorrect" &&
                $this->otherPlayer["answerStatus"] == "pick-artist"
            ) {
                $gameScore->answerStatus = "wait-turn";
            } else {
                //if correct keep the current artist
                $gameScore->answerStatus = "wait-turn";
                $gameScore->artistID = $this->artistId;
                $gameScore->artistName = $this->artistName;
            }
            $gameScore->save();
            //Set other player status
            if ($this->otherPlayer["answerStatus"] != "pick-artist") {
                GameScore::setOtherPlayerStatus(
                    $this->gameId,
                    $user->id,
                    "player-turn",
                    null,
                    $this->artistId,
                    $this->artistName
                );
            }
        }
    }

    public function setOtherPlayer()
    {
        $this->otherPlayer = GameScore::getOtherPlayersStatus($this->gameId);
        Log::info(
            "gameHelperOtherPlayer: " .
                print_r($this->otherPlayer->getAttributes(), true)
        );
    }
}
