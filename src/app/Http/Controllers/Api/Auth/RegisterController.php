<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success'=>true, 'user'=>$user->toArray()], 201);
    }
}
