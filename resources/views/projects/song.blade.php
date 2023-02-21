@extends('layouts.project')

@section('title', 'Laravel Song Application')

@section('project-title', 'A Laravel application where users guess the songs')

@section('date', 'FEB. 20, 2023, AT 5:00 AM')

@section('author', 'A look at the Top 1000 Track Times')

@section('image', 'img/track-running.jpg')

@section('project')

    <img alt="SongArt" src="{{ asset('img/song.jpg') }}">

    <hr>
    <p>This Laravel application is a simple game where users go back and forth seeing who can name the most songs by a given
        musical artist.</p>

    <h2>How the game works</h2>
    <h3>Starting the game</h3>
    <ol>
        <li>Users log in or register for the application</li>
        <li>Users see a list of available players and invite them to play the game</li>
        <li>Once the game is accepted, the game begins</li>
    </ol>

    <h3>The gameplay</h3>

    <p>A user starts by selecting an artist. The user enters an artist name. The application then returns (via an api) a
        list of related artist.
        The user selects the artist from this list.
    </p>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/FirstArtistPick.png') }}">

    <p>Players then go back and forth naming songs by the chosen artist.
    </p>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/GuessTheSong.png') }}">

    <p>Once a player gets a song incorrect the opposing
        player is given one more guess then a new artist is selected.</p>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/PickArtist.png') }}">

    <hr>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/GuessSongNew.png') }}">


    <h3>Technologies used</h3>

    <ul>
        <li>Laravel 8 and Vue2</li>
        <li>Websockets</li>
        <li>Apis</li>
    </ul>

    <h3>Laravel and Vue</h3>

    <p>The application uses Laravel, Vue and an SQL database. It is deployed to an Ubuntu server and is served with Nginx.
    </p>
    <p>Some basic checking on song guesses makes sure the song has not been guessed before and is similar to a song the
        artist performs. I do this using the similar_text function in php:</p>

    <pre><code>similar_text(strtolower($item["title"]), 
            strtolower($this->guess), 
            $perc); </code></pre>

    <p> This allows for matches to be loosly set based on a defined matching percent.</p>

    <p>The data is stored using a relational database.</p>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/DatabaseStructure.png') }}">


    <h3>Websockets</h3>

    <p>Websockets are used so that users don't need to refresh pages between guesses. I used the <a
            href="https://beyondco.de/docs/laravel-websockets/getting-started/introduction" target="_blank">Laravel
            Websockets</a> package
        to send messages to the browser. </p>

    <h3>Api's</h3>

    <p>The <a href="https://www.discogs.com/developers" target="_blank">Discog API </a> is used to
        verfy
        the artist, check the song and return a picture of the selected musician.</p>

    <p>Check the code out on <a href="https://github.com/mttspear/laravel-running" target="_blank">Github</a> or check out
        the application <a href="{{ route('login') }}"> Here </a> </p>

    </div>
@endsection
