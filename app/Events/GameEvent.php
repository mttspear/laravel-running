<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class GameEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    //use SerializesModels;

    public $message;
    public $userId;
    public $gameScore;
    public $gameScores;
    public $discogResults;
    public $activeGame;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        $userId,
        $gameScore,
        $gameScores,
        $discogResults = null,
        $activeGame = null
    ) {
        $this->userId = $userId;
        $this->gameScore = $gameScore;
        $this->gameScores = $gameScores;
        $this->discogResults = $discogResults;
        $this->activeGame = $activeGame;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("game." . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            "data" => [
                "gameScores" => $this->gameScores,
                "gameScore" => $this->gameScore,
                "artist" => $this->discogResults,
                "activeGame" => $this->activeGame,
            ],
        ];
    }
}
