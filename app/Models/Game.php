<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Status Options:
 * pending: the player has a game request pending
 * active:
 * complete:
 */

class Game extends Model
{
    protected $table = "game";
    protected $primaryKey = "id";

    protected $fillable = ["scoreLimit", "status"];

    public function gameScores()
    {
        return $this->hasMany(GameScore::class, "gameId");
    }

    public function scopeGetActiveGame($query)
    {
        return $query
            ->whereHas("gameScores", function ($queryWhere) {
                return $queryWhere
                    ->where("playerId", "=", Auth::user()->id)
                    ->where("status", "=", "active");
            })
            ->first();
    }

    public function scopeSetGameOver($query, $gameId)
    {
        return $query->where("id", "==", $gameId)->update([
            "status" => "game-over",
        ]);
    }
}
