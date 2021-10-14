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


    <game-component :prop-auth-user='{{Auth::user()}}' 
    :prop-active-game='@json($activeGame)' 
    :prop-game-scores='@json($gameScores)' 
    :prop-game-score='@json($gameScore)'
    :prop-artist-info='@json($artist)'
    :prop-inactive-games='@json($inActiveGames)'
    :prop-current-users='@json($currentUsers)'></game-component>
  
</div>
@endsection
