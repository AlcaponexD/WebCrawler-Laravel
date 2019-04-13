<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserLogin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function login(Request $request)
  {
      $credentials = $request->only('user', 'password');
      $user = User::where('user', '=', $request->only('user'))->first();
      try {
          if (! $token = \JWTAuth::attempt($credentials)) {
              return response()->json(['error' => 'invalid_credentials'], 401);
          }
      } catch (\JWTException $e) {
          return response()->json(['error' => 'could_not_create_token'], 500);
      }
      return response()->json([
          'token' => $token,
          'user' => new UserLogin($user)
      ]);
  }

}
