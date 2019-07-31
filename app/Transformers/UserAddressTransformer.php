<?php
namespace App\Transformers;
use App\Captcha;
use App\Models\User;
use App\Models\UserAddress;
use League\Fractal\TransformerAbstract;
class UserAddressTransformer extends TransformerAbstract
{
    public function transform(UserAddress $address)
    {
        return [
            'id' => $address->id,
            'province' => $address->province,
            'city' => $address->city,
            'district' => $address->district,
            'address' => $address->address,
            'contact_name' => $address->contact_name,
            'contact_phone' => $address->contact_phone,
            'last_used_at' => $address->last_used_at,
        ];
    }
}