<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthUserRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(AuthUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message'=>'Wrong credentials'], 400);
        }
        $token = Auth::user()->createToken(config('app.name').', auto api auth.');
        $token->token->expires_at = Carbon::now()->addMonth();
        $token->token->save();

        $tokenResult = [
            'token_type' => 'Bearer',
            'access_token' =>  $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
        ];
        return response()->json(['token'=>$tokenResult]);
    }
}
