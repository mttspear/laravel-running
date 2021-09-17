<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    public function scopeGetCurrentTurn($query, $gameId)
    {
        return $query
            ->where("gameId", $gameId)
            ->where("playerId", "=", Auth::user()->id)
            ->where("answerStatus", "=", "player-turn")
            ->first();
    }

    public function getExpiredAttribute()
    {
        $carbon = new \Carbon\Carbon($this->created_at);
        $carbon->addMinutes($this->expiredMinutes);
        return $carbon->format("Y-m-d H:i:s");
    }
}
