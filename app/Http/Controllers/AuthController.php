<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public $loginAfterSignUp = false;

    public function login(Request $request)
    {
        $credentials = $request->only("nomor_pegawai", "password");
        
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = JWTAuth::user();
        return response()->json([
            "status" => true,
            "token"=>$token,
            "user"=>$user,
        ]);
    }
    public function register(Request $request)
    {
        try {

            if (! $admin_user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(["message" => 'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(["message" => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(["message" => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(["message" => 'token_absent'], $e->getStatusCode());

        }
        if($admin_user->role_id > 1 || $admin_user->id == $request->role_id){
            return response()->json(["message" => 'Forbidden'], 403);
        }
        $validator = Validator::make($request->all(), [
            "nomor_pegawai" => "required|string",
            "nama" => "required|string",
            "password" => "required|string|min:6|max:10",
            "tanggal_lahir" => 'required|date_format:"Y/m/d"',
            "role_id"=>"required|integer|between:1,4",
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        try {
            $user = new User();
            $user->nomor_pegawai = $request->nomor_pegawai;
            $user->nama = $request->nama;
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->role_id = $request->role_id;
            $user->password = bcrypt($request->password);
            $user->save();

            if ($this->loginAfterSignUp) {
                return $this->login($request);
            }

            return response()->json([
                "status" => true,
                "message"=>'User had been created',
                "user" => $user
            ]);
            
        } catch (JWTException $exception) {
            return response()->json([
                "status" => false,
                "message" => "Ops, the user can not be created"
            ]);
        }
        return response()->json(compact('user'));
    }
    public function getuser(Request $request)
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(["message" => 'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(["message" => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(["message" => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(["message" => 'token_absent'], $e->getStatusCode());

        }
        return response()->json([
            "status" => true,
            "message" => $user,
        ]);
    }
    public function getalluser(Request $request)
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(["message" => 'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(["message" => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(["message" => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(["message" => 'token_absent'], $e->getStatusCode());

        }
        if($user->role_id > 1){
            return response()->json(["message"=> 'Forbidden'], 403);
        }
        return response()->json(["data"=> User::all()]);
    }
    public function logout(Request $request)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        try {
            return response()->json([
                "status" => true,
                "message" => "User logged out successfully"
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                "status" => false,
                "message" => "Ops, the user can not be logged out, contact admin"
            ]);
        }
    }
}
