@extends('layouts.project')

@section('title', 'Laravel Song Application')

@section('project-title', 'Guess the Song: A PHP Music Game')

@section('date', 'FEB. 20, 2023, AT 5:00 AM')

@section('author', 'A look at the Top 1000 Track Times')

@section('image', 'img/track-running.jpg')

@section('project')

    <img alt="SongArt" src="{{ asset('img/song.jpg') }}">

    <hr>
    <p>This PHP application is an engaging game where users compete to see who can name the most songs by a given musical artist. It combines user interaction with music knowledge, making it both fun and challenging.</p>

    <h2>How the game works</h2>
    <h3>Starting the game</h3>
    <ol>
        <li><strong>User Authentication:</strong> Users log in or register to access the game.</li>
        <li><strong>Player Selection:</strong> Once logged in, users can view a list of available players and invite them to play.</li>
        <li><strong>Game Initiation:</strong> When the invited player accepts the invitation, the game begins.</li>
    </ol>

    <h3>The Gameplay</h3>

    <h4>1. Artist Selection</h4>

    <ol>
        <li>A user starts by entering the name of a musical artist.</li>
        <li>The application retrieves a list of related artists using an external API.</li>
        <li>The user selects the correct artist from this list to initiate the game.</li>
    </ol>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/FirstArtistPick.png') }}">

    <h4>2. Song Guessing</h4>

    <ol>
        <li>Players take turns guessing songs by the selected artist.</li>
        <li>The application validates the guesses against the artist's discography.</li>
        <li>Players earn points for each correct guess.</li>
    </ol>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/GuessTheSong.png') }}">

    <h4>3. Incorrect Guesses</h4>

    <ol>
        <li>If a player guesses a song incorrectly, the opposing player is given one more guess.</li>
        <li>After this guess, a new artist is selected to continue the game.</li>
    </ol>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/PickArtist.png') }}">

    <hr>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/GuessSongNew.png') }}">

    <h3>Winning The Game</h3>
    <ol>
        <li>The game continues with players alternating turns and guessing songs.</li>
        <li>The first player to reach 5 points wins the game.</li>
    </ol>

    <h3>Technologies used</h3>

    <h4>Frameworks and Libraries</h4>

    <ul>
        <li><strong>PHP 8, Laravel 8 and Vue 2:</strong> The core of the application is built using PHP for the backend and Vue.js for the frontend.</li>
        <li><strong>WebSockets:</strong> Utilized for real-time updates, ensuring users don't need to refresh pages between guesses.</li>
        <li><strong>APIs:</strong>The Discogs API is integrated to verify artists, check songs, and return images of the selected musicians.</li>
    </ul>

    <h4>Deployment and Hosting</h4>

    <ul>
        <li><strong>Server:</strong> The application is deployed on an Ubuntu server.</li>
        <li><strong>Web Server: </strong>Nginx is used to serve the application.</li>
    </ul>

    <h4>Song Guess Validation</h4>

    <p>The application includes basic checks to ensure song guesses have not been previously used and are similar to the artist's actual songs. This is achieved using PHP’s similar_text function:</p>

    <pre><code>similar_text(strtolower($item["title"]), 
            strtolower($this->guess), 
            $perc); </code></pre>

    <p>This function allows for matches to be loosely set based on a defined matching percentage.</p>

    <h4>Data Storage</h4>

    <ul>
        <li><strong>Database:</strong> A relational SQL database is used for storing all game data, including users, games, and song guesses.</li>
    </ul>

    <img class="img-fluid" alt="SongArt" src="{{ asset('img/DatabaseStructure.png') }}">

    <h4>Real-Time Communication</h4>

    <ul>
        <li><strong>WebSockets:</strong> Laravel WebSockets package is employed to send real-time messages to the browser, allowing for seamless user experience without the need to refresh the page.</li>
    </ul>

    <h4>API Integration</h4>
    <ul>
        <li><strong>Discogs API:</strong>This <a href="https://www.discogs.com/developers" target="_blank"> API </a>  is used to verify artists, check song titles, and fetch images of the selected musicians, enhancing the game's functionality and user experience.</li>
    </ul>

    <h4>Check It Out</h4>
    <ul>
        <li><strong>Code Repository:</strong> The code is available on GitHub <a href="https://github.com/mttspear/laravel-running" target="_blank">here</a>. </li>
        <li><strong>Live Application: </strong> Try out the application <a href="{{ route('login') }}"> here</a>.</li>
    </ul>

    </div>
@endsection
