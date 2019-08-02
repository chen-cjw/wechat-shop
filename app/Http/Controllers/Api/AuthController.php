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
        $code = '';
        // 小程序
        $app = app('wechat.mini_program');
        $user = User::where('openid',$request->openid)->firstOrFail();

//        if (!$user) {
//            $sessionUser = $app->auth->session($code);
//            $user = User::create([
//                'nickname' => $sessionUser->getNickname(),
//                'avatar' => $sessionUser->getAvatar(),
//                'openid' => $sessionUser->getId(),
//                'unionid' => $sessionUser->unionid,
//            ]);
//        }
        $token=\Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token)->setStatusCode(201);

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
    protected function respondWithToken($token)
    {

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 864000
        ]);
    }
}
