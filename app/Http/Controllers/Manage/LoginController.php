<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Manage\LoginRequest;

class LoginController extends BaseController
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->all(['username', 'password']);

        if (! $token = auth('manage')->attempt($credentials)) {
            return $this->fail_return('用户名或密码错误');
        }

        return $this->respondWithToken($token,'Successfully logged in ');
    }

    public function me()
    {
        $user = auth('manage')->user();

        unset($user['password']);

        return $this->success_return($user);
    }

    public function logout()
    {
        auth('manage')->logout();

        return $this->success_return(auth('manage')->user(),'Successfully logged out');
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('manage')->refresh());
    }

    protected function respondWithToken($token,$message = '')
    {
        return $this->success_return([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('manage')->factory()->getTTL() * 60
        ],$message);
    }
}
