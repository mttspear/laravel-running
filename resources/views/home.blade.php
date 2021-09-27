@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex align-items-center justify-content-center mt-3"> 
            <img class="welcome_img img-responsive" src={{ asset('img/bye.png') }}>
            <span class ="welcome_player ml-2"> Welcome <span class ="player_name">{{ auth()->user()->name }} ({{ auth()->user()->id }})</span> </span>
        </div>
        <div class="col-md-12 text-center"> 
            <div class ="welcome_message mb-5"> Start a game and guess the song! </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3> <img class="icon_img " src={{ asset('img/community.png') }}> Past Games</h3>
            <user-games-component  :games='@json($inActiveGames)'></user-games-component>
        </div>
        <div class="col-md-6">
            
            <h3><img class="icon_img " src={{ asset('img/community.png') }}> Available Players</h3>
            <available-players-component :auth-user='{{Auth::user()}}' :current-users='@json($currentUsers)' v-on:custom="test()"></available-players-component>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Current Game</h3>
            <game-component :auth-user='{{Auth::user()}}' 
            :active-game='@json($activeGame)' 
            :game-scores='@json($gameScores)' 
            :game-score='@json($gameScore)'
            :artist-info='@json($artist)'></game-component>
        </div>
    </div>
</div>
@endsection
