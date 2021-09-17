<?php

namespace App\Helpers\Users;
use Illuminate\Support\Facades\Auth;

class Users
{
    public static $CURRENT_SUB_MINUTES = 90;

    /**
     * Function to return the players currently logged on with no pending game
     */
    public static function getCurrentUsersWithNoPendingGame()
    {
        $previousTime = now()->subMinutes(self::$CURRENT_SUB_MINUTES)
            ->timestamp;
        $id = Auth::user()->id;

        $data = \DB::table("sessions")
            ->select("sessions.user_id", "name")
            ->addSelect(\DB::raw("null as game_id, null as status"))
            ->join("users", "users.id", "=", "sessions.user_id")
            ->where("user_id", "!=", $id)
            ->where("last_activity", ">", $previousTime)
            ->get();
        return $data;
    }

    /**
     * Get a users pending games
     */
    public static function getUsersPendingGames()
    {
        $id = Auth::user()->id;

        $session = \DB::table("game_score")
            ->select(
                "opponent.playerId as user_id",
                "users.name",
                "game.id as game_id",
                "game.status"
            )
            ->join("game_score AS opponent", function ($join) {
                $join->on("opponent.gameId", "=", "game_score.gameId");
                $join->on("opponent.playerId", "!=", "game_score.playerId");
            })
            ->join("users", "users.id", "=", "opponent.playerId")
            ->leftJoin("game", "game.id", "=", "game_score.gameId")
            ->where("game_score.playerId", "=", $id)
            ->distinct()
            ->get();
        return $session;
    }
}
