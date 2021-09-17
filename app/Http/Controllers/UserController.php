<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\Discog\Discog;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $request->session()->put('key', 'value');
        Session(['key' => 'value']);
        Session()->save();
        $previousTime = now()->subMinutes(2)->timestamp;

        $users = User::all();
        $data = $request->session()->all();
        $session = \DB::table('sessions')
            ->join('users', 'users.id', '=', 'sessions.user_id')
            //->where('user_id', '=', $user->id)
            ->where('last_activity', '>', $previousTime)
            ->get();

        dd($session);

        $client = New Discog();

        //return a list of users

        return view('user.profile', [
        ]);
    }
}