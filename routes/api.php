<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UseropController;
use App\Http\Controllers\SpotifyServer;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post("/register", [UseropController::class, "registerUser"]);
Route::post("/login", [UseropController::class, "loginUser"]);

Route::get('/test',function (){
    return response()->json([
        "error" => "Unauthorized",
    ], 401);
})->name('mustLogin');


Route::middleware("auth:api")->group(function (){

    Route::get("/profile", [UseropController::class, "userProfile"]);
    Route::post("/profile/change/pic", [UseropController::class, "changeProfilePic"]);

    Route::get("/spotify/artist", [SpotifyServer::class, "artistInfo"]);
    Route::get("/spotify/artist/genres", [SpotifyServer::class, "artistGenres"]);
    Route::get("/spotify/artist/albums", [SpotifyServer::class, "artistAlbums"]);
    Route::get("/spotify/artist/tracks", [SpotifyServer::class, "artistTracks"]);
    Route::get("/spotify/album/tracks", [SpotifyServer::class, "albumTrack"]);

    Route::get("/genres", [ApiController::class, "localGenres"]);
    Route::get("/artist", [ApiController::class, "localArtist"]);
    Route::get("/artist/album", [ApiController::class, "localArtistAlbums"]);
    Route::get("/artist/tracks", [ApiController::class, "getArtistTracks"]);
    Route::get("/album", [ApiController::class, "localAlbum"]);

});
