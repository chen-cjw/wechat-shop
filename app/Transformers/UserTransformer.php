<?php
namespace App\Transformers;
use App\Captcha;
use App\Models\User;
use League\Fractal\TransformerAbstract;
class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'openid' => $user->openid,
            'nickname' => $user->nickname,
            'sex' => $user->sex,
            'avatar' => $user->avatar,
            'created_at' => $user->created_at->timestamp,
            'updated_at' => $user->updated_at->timestamp,
        ];
    }
}