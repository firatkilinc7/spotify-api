<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\GenreModel;
use App\Models\ArtistModel;
use App\Models\AlbumModel;
use App\Models\TrackModel;

function getToken(){

    $clientId = env('SPOTIFY_CLIENT_ID');
    $clientSecret = env('SPOTIFY_CLIENT_SECRET');

    $response = Http::asForm()->withHeaders([
        'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret"),
    ])->post('https://accounts.spotify.com/api/token', [
        'grant_type' => 'client_credentials',
    ]);

    $token = $response->json('access_token');
    return $token;
}

function getArtist($artistId)
{
    $token = getToken();

    $response = Http::withHeaders([
        "Authorization" => "Bearer $token",
    ])->get("https://api.spotify.com/v1/artists/$artistId");

    if(!($response->status() === 200)){
        return $response;
    }

    $spotifyId      = $response->json("id");
    $artistName     = $response->json("name");
    $totalFollowers = $response->json("followers")["total"];
    $popularity     = $response->json("popularity");
    $genres         = $response->json("genres");

    $newArtist = ArtistModel::updateOrCreate(
        ["spotify_id"         => $spotifyId],
        [
            "name"            => $artistName,
            "total_followers" => $totalFollowers,
            "popularity"      => $popularity
        ]);

    $genreIds = [];
    foreach ($genres as $genre){

        $dbGenre = GenreModel::updateOrCreate(
            ['name' => $genre],
            ['name' => $genre]
        );
        $genreIds[] = $dbGenre->id;
    }

    $newArtist->artistGenres()->sync($genreIds);

    return $response;
}

function getAlbum($artistId, $market){
    $token = getToken();

    $response = Http::withHeaders([
        "Authorization" => "Bearer $token",
    ])->get("https://api.spotify.com/v1/artists/$artistId/albums?market=$market&limit=50&offset=0");

    if(!($response->status() === 200)){
        return $response;
    }

    $results = $response->json("items");

    foreach ($results as $result){

        $releaseDate = $result["release_date"];

        if (preg_match('/^\d{4}$/', $releaseDate)) {
            $releaseDate .= '-01-01';
        }

        elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $releaseDate)) {
            $releaseDate .= '-01';
        }

        AlbumModel::updateOrCreate(
            ["spotify_id" => $result["id"]],
            [
                "artist_id" => $artistId,
                "name"      => $result["name"],
                "release_date" => $releaseDate,
                "total_track"  => $result["total_tracks"]
            ]
        );
    }

    return $response;

}

function getAlbumTrack($artistId, $albumId, $market){
    $token = getToken();

    $response = Http::withHeaders([
        "Authorization" => "Bearer $token",
    ])->get("https://api.spotify.com/v1/albums/$albumId/tracks?market=$market&limit=50&offset=0");

    if(!($response->status() === 200)){
        return $response;
    }

    $results = $response->json("items");

    foreach ($results as $result){
        TrackModel::updateOrCreate(
            ["spotify_id" => $result["id"]],
            [
                "album_id"  => $albumId,
                "artist_id" => $artistId,
                "name"      => $result["name"],
                "duration"  => $result["duration_ms"],
                "explicit"  => $result["explicit"] === false ? "0" : "1"
            ]
        );
    }

    return $response;

}
