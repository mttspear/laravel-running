<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Status Options:
 * pending: the player has a game request pending
 * proposed: the player who proposed the game NEED TO ADD
 * pick-artist: the player needs to pick a category to start the game
 * correct: the player guessed correctly
 * incorrect: the player guessed incorrectly
 * wait-turn: the player is waiting on another players turn
 * player-turn: it is the players turn to submit an answer
 */
class GameScore extends Model
{
    protected $table = "game_score";
    protected $primaryKey = "id";

    protected $fillable = [
        "artistID",
        "artistName",
        "playerAnswer",
        "answerStatus",
        "playerId",
        "gameId",
    ];

    protected $appends = ["expired"];

    public $expiredMinutes = 5;

    public function Game()
    {
        return $this->belongsTo(Game::class, "gameId");
    }

    public function User()
    {
        return $this->belongsTo(User::class, "playerId");
    }

    public function scopeGetCurrentUserTurn($query, $gameId)
    {
        return $query
            ->where("gameId", $gameId)
            ->where("playerId", "=", Auth::user()->id)
            ->where("answerStatus", "=", "player-turn")
            ->first();
    }

    public function scopeGetCurrentTurn($query, $gameId)
    {
        return $query
            ->where("gameId", $gameId)
            ->where(function ($query) {
                $query
                    ->where("answerStatus", "=", "player-turn")
                    ->orWhere("answerStatus", "=", "pick-artist");
            })
            ->first();
    }

    public function getExpiredAttribute()
    {
        $carbon = new Carbon($this->updated_at);
        $carbon->addMinutes($this->expiredMinutes);
        return $carbon->format("Y-m-d H:i:s");
    }

    public function scopeGetGameScore($query, $gameId)
    {
        return $query
            ->select("playerId", "name", DB::raw("count(*) as score"))
            ->join("users", "users.id", "=", "game_score.playerId")
            ->where("gameId", "=", $gameId)
            ->where("answerStatus", "=", "correct")
            ->groupBy("playerId")
            ->get();
    }

    public function scopeGetOtherPlayersStatus($query, $gameId)
    {
        return $query
            ->where("gameId", "=", $gameId)
            ->where("playerId", "!=", Auth::user()->id)
            ->orderBy("updated_at", "DESC")
            ->orderBy("id", "DESC")
            ->first();
    }

    public function scopeGetOtherPlayer($query, $gameId)
    {
        return $query
            ->select("playerId")
            ->where("gameId", "=", $gameId)
            ->where("playerId", "!=", Auth::user()->id)
            ->first();
    }

    public function scopeSetGameOver($query, $gameId)
    {
        return $query
            ->where("gameId", "=", $gameId)
            ->whereNull("playerAnswer")
            ->update([
                "answerStatus" => "complete",
            ]);
    }

    public function scopeSetCurrentPlayerStatus(
        $query,
        $gameId,
        $userId,
        $status,
        $guess,
        $artistId,
        $artistName
    ) {
        return $query
            ->where("gameId", $gameId)
            ->where("playerId", $userId)
            ->whereNull("playerAnswer")
            ->update([
                "answerStatus" => $status,
                "playerAnswer" => $guess,
                "artistName" => $artistName,
                "artistID" => $artistId,
            ]);
    }

    public function scopeSetOtherPlayerStatus(
        $query,
        $gameId,
        $userId,
        $status,
        $guess,
        $artistId,
        $artistName
    ) {
        return $query
            ->where("gameId", $gameId)
            ->where("playerId", "!=", $userId)
            ->whereNull("playerAnswer")
            ->update([
                "answerStatus" => $status,
                "playerAnswer" => $guess,
                "artistName" => $artistName,
                "artistID" => $artistId,
            ]);
    }

    public function scopeGetGameScores($query, $gameId)
    {
        return $query
            ->select(
                "artistName",
                "playerAnswer",
                "playerId",
                "answerStatus",
                "game_score.updated_at",
                "name as playerName"
            )
            ->join("users", "users.id", "=", "game_score.playerId")
            ->where("gameId", $gameId)
            ->orderBy("game_score.updated_at", "desc")
            ->get();
    }
}
