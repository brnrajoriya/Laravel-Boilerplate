<?php

namespace App\Api\V1\Controllers;

use Config;
use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Auth;
use Spatie\Permission\Models\Role;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $request['refer_key'] = str_random(Config::get('default.refer_key_length'));
        $request['is_approved'] = $request->input('role_id', Config::get('default.is_approved'));
        $user = new User($request->all());
        if(!$user->save()) {
            throw new HttpException(500);
        }
        if(Config::get('default.role_id')) {
            $role = Role::find(Config::get('default.role_id'));
            $user->assignRole($role);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'user' => $user,
            'expires_in' => Auth::guard()->factory()->getTTL() * 60,
            'message' => 'You have Registered Seccessfully !',
            'title' => 'Registered !'
        ], 201);
    }
}
