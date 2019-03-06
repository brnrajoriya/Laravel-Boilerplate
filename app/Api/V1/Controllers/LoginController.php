<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use App\Api\V1\Requests\SocialLoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\User;
use Auth;
use Config;

class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $field = 'username';

        if (is_numeric($request->input('username'))) {
            $field = 'mobile';
        } elseif (filter_var($request->input('username'), FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }

        $request->merge([$field => $request->input('username')]);
        
        $credentials = $request->only([$field, 'password']);

        try {
            $token = Auth::guard()->attempt($credentials);

            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'user' => Auth::user(),
            'expires_in' => Auth::guard()->factory()->getTTL() * 60,
            'message' => 'You have Logged In Seccessfully !',
            'title' => 'Loggin In !'
        ]);
    }

    public function socialLogin(SocialLoginRequest $request, JWTAuth $JWTAuth)
    {
        $data = $request->all();
        $user = User::whereEmail($data['email'])->first();

        if(!$user) {
            $request['refer_key'] = str_random(Config::get('default.refer_key_length'));
            $request['role_id'] = $request->input('role_id', Config::get('default.role_id'));
            $request['password'] = Config::get('default.social_password');
            $user = new User($request->only('name', 'email', 'mobile', 'refer_key', 'referred_by_key', 'role_id', 'location_id', 'password'));
            if(!$user->save()) {
                throw new HttpException(500);
            }
        }
        
        $socialAccount = $user->socialAuthentications()->where('provider', $data['provider'])->first();
        if(!$socialAccount) {
            $user->socialAuthentications()->create([
                'provider' => $data['provider'],
                'provider_id' => $data['provider_id'],
                'access_token' => $data['access_token'],
                'image' => isset($data['image']) ? $data['image'] : null
            ]);
        } else {
            $socialAccount->provider_id = $data['provider_id'];
            $socialAccount->access_token = $data['access_token'];
            $socialAccount->image = isset($data['image']) ? $data['image'] : null;
            $socialAccount->save();
        }

        // if(!Config::get('boilerplate.social_login.release_token')) {
        //     return response()->json([
        //         'status' => 'ok'
        //     ], 201);
        // }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'user' => $user,
            'expires_in' => Auth::guard()->factory()->getTTL() * 60,
            'message' => 'You have Logged In Seccessfully !',
            'title' => 'Loggin In !'
        ], 201);
    }
}
