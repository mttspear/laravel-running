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

class UserEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    //use SerializesModels;

    public $userId;
    public $currentUsers;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $currentUsers)
    {
        $this->currentUsers = $currentUsers;
        $this->userId = $userId;
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
                "currentUsers" => $this->currentUsers,
            ],
        ];
    }
}
