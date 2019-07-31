<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use App\Transformers\UserAddressTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAddressController extends Controller
{

    public function index()
    {
        return $this->response->item($this->user()->addresses,new UserAddressTransformer());
    }
    // 添加地址
    public function store(UserAddressRequest $request)
    {
        $this->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'contact_name',
            'contact_phone',
        ]));
        return $this->response->created();
    }

    // 修改 收获地址
    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return $this->response->created();

    }

    // 删除
    public function destroy($id)
    {
        UserAddress::findOrFail($id);
        return $this->response->noContent();
    }

}
