<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public $loginAfterSignUp = false;

    public function login(Request $request)
    {
        $credentials = $request->only("nomor_pegawai", "password");
        $token = null;

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                "status" => false,
                "message" => "Unauthorized"
            ]);
        }

        return response()->json([
            "status" => true,
            "token" => $token
        ]);
    }
    public function register(Request $request)
    {
        $admin_user = JWTAuth::authenticate($request->token);
        if($admin_user->role_id > 1) {
            return response()->json([
                "status" => false,
                "token" => "Unauthorized"
            ]);
        }
        $this->validate($request, [
            "token" => "required"
        ]);
        $this->validate($request, [
            "nomor_pegawai" => "required|string",
            "nama" => "required|string",
            "password" => "required|string|min:6|max:10",
            "tanggal_lahir" => 'required|date_format:"Y/m/d"',
            "role_id"=>"required|integer|between:1,4",
        ]);
        try {
            JWTAuth::invalidate($request->token);
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
                "message" => "Ops, the user can not be logged out"
            ]);
        }
    }
    public function getuser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
        
        return response()->json(['user' => $user]);
    }
    public function logout(Request $request)
    {
        $this->validate($request, [
            "token" => "required"
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                "status" => true,
                "message" => "User logged out successfully"
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                "status" => false,
                "message" => "Ops, the user can not be logged out"
            ]);
        }
    }
}
