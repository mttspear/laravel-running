<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("welcome");
});

Route::get("/heartbeat", function () {
    return '&#9825;';
});


Route::get("/user", [UserController::class, "show"]);

Auth::routes();

Route::get("/home", [
    App\Http\Controllers\HomeController::class,
    "index",
])->name("home");

Route::post("/add-game", [GameController::class, "createGame"]);

Route::post("/start-game", [GameController::class, "startGame"]);

Route::post("/submit-artist", [GameController::class, "submitArtist"]);

Route::post("/confirm-artist", [GameController::class, "confirmArtist"]);

Route::post("/submit-song", [GameController::class, "submitSong"]);

Route::get("/running", function () {
    return view('projects.running');
});

Route::get("/mission-22", function () {
   return \File::get(public_path() . '/mission-22.html');
});
