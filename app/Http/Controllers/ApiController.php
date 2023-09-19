<?php

namespace App\Http\Controllers;

use App\Models\AlbumModel;
use App\Models\ArtistModel;
use App\Models\GenreModel;
use App\Models\TrackModel;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/genres",
     *   tags={"Local Api"},
     *   summary="Get All Genres",
     *   security={{"Bearer":{}}},
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */

    public function localGenres(){
       $genres = GenreModel::all();
        if (!$genres){
            return response()->json([
                "error" => "Not found on local server"
            ], 404);
        }

        return response()->json([
            "genres" => $genres
        ], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/artist",
     *   tags={"Local Api"},
     *   summary="Get Artist",
     *   description="Required => token, artistId",
     *   security={{"Bearer":{}}},
     *   @OA\Parameter(
     *      name="artistId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */

    public function localArtist(Request $request){
        $artist = ArtistModel::find($request->artistId);

        if (!$artist){
            return response()->json([
                "error" => "Not found on local server"
            ], 404);
        }

        return response()->json([
            $artist->spotify_id => $artist,
            "genres" => $artist->artistGenres
        ], 200);
    }



    /**
     * @OA\Get(
     *   path="/api/artist/album",
     *   tags={"Local Api"},
     *   summary="Get Artist's Album",
     *   description="Required => token, artistId",
     *   security={{"Bearer":{}}},
     *   @OA\Parameter(
     *      name="artistId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */

    public function localArtistAlbums(Request $request){
        $albums = AlbumModel::query()
            ->where(["artist_id" => $request->artistId])
            ->get();

        if (!$albums){
            return response()->json([
                "error" => "Not found on local server"
            ], 404);
        }

        return response()->json([
            "albums" => $albums,
        ], 200);
    }



    /**
     * @OA\Get(
     *   path="/api/artist/tracks",
     *   tags={"Local Api"},
     *   summary="Get Artist's Tracks",
     *   description="Required => token, artistId",
     *   security={{"Bearer":{}}},
     *   @OA\Parameter(
     *      name="artistId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */

    public function getArtistTracks(Request $request){
        $tracks = TrackModel::query()
            ->where(["artist_id" => $request->artistId])
            ->get();

        if (!$tracks){
            return response()->json([
                "error" => "Not found on local server"
            ], 404);
        }

        return response()->json([
            "tracks" => $tracks
        ], 200);
    }



    /**
     * @OA\Get(
     *   path="/api/album",
     *   tags={"Local Api"},
     *   summary="Get Album",
     *   description="Required => token, albumId",
     *   security={{"Bearer":{}}},
     *   @OA\Parameter(
     *      name="albumId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */

    public function localAlbum(Request $request){
        $album = AlbumModel::query()
            ->where(["spotify_id" => $request->albumId])
            ->first();

        $tracks = TrackModel::query()
            ->where(["album_id" => $album->spotify_id])
            ->get();

        if (!$album or !$tracks){
            return response()->json([
                "error" => "Not found on local server"
            ], 404);
        }

        return response()->json([
            "album" => $album,
            "tracks"  => $tracks
        ], 200);

    }



}
