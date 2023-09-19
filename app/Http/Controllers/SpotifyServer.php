<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpotifyServer extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/spotify/artist",
     *   tags={"Spotify Api"},
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

    public function artistInfo(Request $request){
        $response = getArtist($request->artistId);
        $status = $response->status();

        if (!($status == 200)){
            if ($status == 400 or $status == 404){
                return response()->json([
                    "error" => "Invalid id"
                ], 400);
            }elseif ($status == 401){
                return response()->json([
                    "error" => "Spotify token error"
                ], 401);
            }elseif ($status == 429){
                return response()->json([
                    "error" => "Spotify request limit exceeded"
                ], "429");
            }
        }

        return response($response);
    }


    /**
     * @OA\Get(
     *   path="/api/spotify/artist/genres",
     *   tags={"Spotify Api"},
     *   summary="Get Artist Genres",
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

    public function artistGenres(Request $request){
        $response = getArtist($request->artistId);
        $status = $response->status();

        if (!($status == 200)){
            if ($status == 400 or $status == 404){
                return response()->json([
                    "error" => "Invalid id"
                ], 400);
            }elseif ($status == 401){
                return response()->json([
                    "error" => "Spotify token error"
                ], 401);
            }elseif ($status == 429){
                return response()->json([
                    "error" => "Spotify request limit exceeded"
                ], "429");
            }
        }

        return response([
            $response["name"] => $response["genres"]
        ], 200);
    }



    /**
     * @OA\Get(
     *   path="/api/spotify/artist/albums",
     *   tags={"Spotify Api"},
     *   summary="Get Artist Albums",
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
     *   @OA\Parameter(
     *       name="market",
     *       in="query",
     *       required=false,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
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

    public function artistAlbums(Request $request){
        $response = getAlbum($request->artistId, isset($request->market) ? $request->market : "TR");

        $status = $response->status();

        if (!($status == 200)){
            if ($status == 400 or $status == 404){
                return response()->json([
                    "error" => "Invalid id"
                ], 400);
            }elseif ($status == 401){
                return response()->json([
                    "error" => "Spotify token error"
                ], 401);
            }elseif ($status == 429){
                return response()->json([
                    "error" => "Spotify request limit exceeded"
                ], "429");
            }
        }

        return response($response["items"]);

    }



    /**
     * @OA\Get(
     *   path="/api/spotify/album/tracks",
     *   tags={"Spotify Api"},
     *   summary="Get Album's Track",
     *   description="Required => token, artistId, albumId",
     *   security={{"Bearer":{}}},
     *   @OA\Parameter(
     *      name="artistId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="albumId",
     *       in="query",
     *       required=true,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
     *   @OA\Parameter(
     *       name="market",
     *       in="query",
     *       required=false,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
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

    public function albumTrack(Request $request){

        $response = getAlbumTrack($request->artistId, $request->albumId, isset($request->market) ? $request->market : "TR");
        $status = $response->status();

        if (!($status == 200)){
            if ($status == 400 or $status == 404){
                return response()->json([
                    "error" => "Invalid id"
                ], 400);
            }elseif ($status == 401){
                return response()->json([
                    "error" => "Spotify token error"
                ], 401);
            }elseif ($status == 429){
                return response()->json([
                    "error" => "Spotify request limit exceeded"
                ], "429");
            }
        }

        return response($response);
    }



    /**
     * @OA\Get(
     *   path="/api/spotify/artist/tracks",
     *   tags={"Spotify Api"},
     *   summary="Get Artist's Track",
     *   description="Required => token, artistId

    After fetching an album, there is a 2-second wait for the next album.",
     *   security={{"Bearer":{}}},
     *   @OA\Parameter(
     *      name="artistId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="market",
     *       in="query",
     *       required=false,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
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

    public function artistTracks(Request $request){
        $responseAlbums = getAlbum($request->artistId, isset($request->market) ? $request->market : "TR");
        $status = $responseAlbums->status();

        if (!($status == 200)){
            if ($status == 400 or $status == 404){
                return response()->json([
                    "error" => "Invalid id"
                ], 400);
            }elseif ($status == 401){
                return response()->json([
                    "error" => "Spotify token error"
                ], 401);
            }elseif ($status == 429){
                return response()->json([
                    "error" => "Spotify request limit exceeded"
                ], "429");
            }
        }

        $allTracks = [];

        foreach ($responseAlbums->json("items") as $album){
            $responseTracks = getAlbumTrack($request->artistId, $album["id"], isset($request->market) ? $request->market : "TR");
            if (!($status == 200)){
                if ($status == 400 or $status == 404){
                    return response()->json([
                        "error" => "Invalid id"
                    ], 400);
                }elseif ($status == 401){
                    return response()->json([
                        "error" => "Spotify token error"
                    ], 401);
                }elseif ($status == 429){
                    return response()->json([
                        "error" => "Spotify request limit exceeded"
                    ], "429");
                }
            }
            $allTracks[] = $responseTracks->json("items");
        }

        return response()->json($allTracks);
    }
}
