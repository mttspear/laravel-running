<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = "game";
    protected $primaryKey = "id";

    protected $fillable = ["scoreLimit", "status"];

    public function gameScores()
    {
        return $this->hasMany(GameScore::class, "gameId");
    }
}
