<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\Product;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    // 查看购物车
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems()->paginate(16);
        return $this->response->paginator($cartItems,new CartTransformer());
    }

    // 添加购物车
    public function store(AddCartRequest $request)
    {
        $user   = $request->user();
        $productId  = $request->input('product_id');
        $amount = $request->input('amount');

        // 从数据库中查询该商品是否已经在购物车中
        if ($cart = $user->cartItems()->where('product_id', $productId)->first()) {

            // 如果存在则直接叠加商品数量
            $cart->update([
                'amount' => $cart->amount + $amount,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->product()->associate($productId);
            $cart->save();
        }
        return $this->response->created();
    }

    // 从购物车中移除商品
    public function destroy(Request $request,$id)
    {
        $request->user()->cartItems()->where('product_id', $id)->delete();
        return $this->response->noContent();
    }
}
