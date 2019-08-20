<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function index()
    {
        return 111;
    }
    // 一个是登陆
    public function store(Request $request)
    {
        $code = $request->code;
        // 小程序
        $app = app('wechat.mini_program');
        $sessionUser = $app->auth->session($code);
        $openid = $sessionUser['openid'];
        $user = User::where('openid',$openid)->first();
        if (!$user) {
            $user = User::create([
                'openid' => $openid,
            ]);
        }
        $token=\Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token,$openid)->setStatusCode(201);

    }

    // 个人中心
    public function meShow()
    {
        return $this->response->item($this->user(),new UserTransformer());
    }
    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }
    protected function respondWithToken($token,$openid)
    {

        return $this->response->array([
            'access_token' => $token,
            'openid' => $openid,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 10080
        ]);
    }
}
