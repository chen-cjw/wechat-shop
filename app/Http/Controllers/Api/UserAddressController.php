<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use App\Transformers\UserAddressTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{

    public function index()
    {
        return $this->response->collection($this->user()->addresses()->get(),new UserAddressTransformer());
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
    // 默认选中地址
    public function select($id)
    {
        try {
            DB::beginTransaction();
            $this->user()->addresses()->update(['is_check'=>0]);
            $this->user()->addresses()->where('id',$id)->update(['is_check'=>1]);

            DB::commit();
            return $this->response->item(UserAddress::find($id),new UserAddressTransformer())->setStatusCode(200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
    // 删除
    public function destroy($id)
    {
        UserAddress::findOrFail($id);
        return $this->response->noContent();
    }

}
