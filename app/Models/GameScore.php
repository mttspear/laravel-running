<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    protected $table = 'game_score';
    protected $primaryKey = 'id';

    protected $fillable = [
        'artistID',
        'artistName',
        'playerAnswer',
        'answerStatus',
        'playerId',
        'gameId'
    ];

    public function Game()
    {
        return $this->belongsTo(Game::class, 'gameId');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'playerId');
    }
    
}
