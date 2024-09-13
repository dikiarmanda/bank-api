<?php

namespace App\Http\Controllers\Api;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator) {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $result = $user->save();
            if ($result) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => 'Your registration has been successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 4000,
                    'success' => false,
                    'message' => 'Something went wrong.',
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'success' => false,
                'error' => $validator->errors(),
            ]);
        }

    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid credentials'], 400);
        }

        // Ambil kredensial dari request
        $credentials = $request->only('username', 'password');

        try {
            // Coba login dengan kredensial yang diberikan
            if (!$token = JWTAuth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // Berikan response dengan accessToken dan refreshToken
        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $this->createRefreshToken($request->user())
        ]);
    }

    public function updateToken(Request $request)
    {
        // Validasi bahwa refresh token dikirimkan
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $validator->errors()
            ], 422); // HTTP status 422 Unprocessable Entity
        }

        try {
            // Mengatur refresh token dari request
            $refreshToken = $request->token;

            // Mencoba untuk merefresh token dan mendapatkan token baru
            $newToken = JWTAuth::setToken($refreshToken)->refresh();

            // Mendapatkan refresh token baru
            $newRefreshToken = JWTAuth::refresh($refreshToken);

            // Mengembalikan accessToken dan refreshToken baru dalam respons
            return response()->json([
                'accessToken' => $newToken,
                'refreshToken' => $newRefreshToken
            ], 200);
        } catch (JWTException $e) {
            // Jika ada kesalahan saat melakukan refresh token
            return response()->json([
                'error' => 'Could not refresh token',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    private function createRefreshToken($user)
    {
        return JWTAuth::fromUser($user);
    }
}
