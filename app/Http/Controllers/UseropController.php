<?php

namespace App\Http\Controllers;

use App\Http\Requests\PicRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isNull;

class UseropController extends Controller
{



    /**
     * @OA\Post(
     *   path="/api/register",
     *   tags={"User Op"},
     *   summary="User Register",
     *   description="Required => fullname, email, phone, password",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="fullname",
     *           type="string",
     *           description="Ad Soyad",
     *         ),
     *         @OA\Property(
     *           property="email",
     *           type="string",
     *           format="email",
     *           description="E-Posta",
     *         ),
     *         @OA\Property(
     *           property="phone",
     *           type="string",
     *           description="Telefon Numarası",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           format="password",
     *           description="Parola",
     *         ),
     *         @OA\Property(
     *           property="profile_pic",
     *           type="string",
     *           format="binary",
     *           description="Profil Resmi",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Ok",
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad Request",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not Found",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */


    public function registerUser(RegisterRequest $request){

        $user           = new User();
        $user->fullname = $request->fullname;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->password = md5($request->password);

        if (isset($request->profile_pic)){
            $user->user_img = uploadImage($request->profile_pic, "/uploads", characterChanger($request->fullname));
        }

        $user->save();

        Auth::login($user);

        $returnData["token"] = $user->createToken("Login")->accessToken;

        return response()->json([
            "success" => $returnData
        ], 201);

    }



    /**
     * @OA\Post(
     *   path="/api/login",
     *   tags={"User Op"},
     *   summary="User Login",
     *   description="Required => email, password",
     *   @OA\Parameter(
     *       name="email",
     *       in="query",
     *       required=true,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
     *    @OA\Parameter(
     *       name="password",
     *       in="query",
     *       required=true,
     *       @OA\Schema(
     *            type="string"
     *       )
     *     ),
     *
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

    public function loginUser(Request $request){

        if (Auth::attempt(["email" => $request->email, "password" => md5($request->password)])){
            $user = Auth::user();

            $returnData["token"] = $user->createToken("Login")->accessToken;

            return response()->json([
                "success" => $returnData
            ], 200);

        }else{
            return response()->json([
                "error" => "Unauthorized"
            ], 401);
        }
    }



    /**
     * @OA\Get(
     *   path="/api/profile",
     *   tags={"User Op"},
     *   summary="User Profile",
     *   description="Required => token",
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

    public function userProfile(){
        $user = Auth::user();

        $returnData = $user;
        isNull($user->user_img) ? $returnData["profile_pic_url"] = null : $returnData["profile_pic_url"] = url("uploads/$user->user_img");

        return response()->json([
            "success" => $returnData
        ], 200);
    }


    /**
     * @OA\Post(
     *   path="/api/profile/change/pic",
     *   tags={"User Op"},
     *   summary="User Profile Pic Change",
     *   description="Required => picture",
     *   security={{"Bearer":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="profile_pic",
     *           type="string",
     *           format="binary",
     *           description="Profil Resmi",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Ok",
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad Request",
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not Found",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Server Error",
     *   ),
     * )
     */

    public function changeProfilePic(PicRequest $request){

        $user = User::find(Auth::user()->id);

        $imagePath = public_path('uploads/'.$user->user_img);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $user->user_img = uploadImage($request->profile_pic, "/uploads", characterChanger($request->fullname));
        if($user->save()){

            $returnData = $user;
            $returnData["profile_pic_url"] = url("uploads/$user->user_img");
            return response()->json([
                "success" => $returnData
            ], 200);

        }else{

            return response()->json([
                "error" => "Image Upload Error"
            ], 500);
        }



    }
}
