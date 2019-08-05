<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\UserAddress;
use App\Models\Order;

class OrdersController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::query()
            // 使用 with 方法预加载，避免N + 1问题
            ->with(['items.product'])
            ->where('user_id', $this->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        return $this->response->paginator($orders,new OrderTransformer());
    }

    public function show($id)
    {
        $order = Order::query()
            // 使用 with 方法预加载，避免N + 1问题
            ->with(['items.product'])
            ->where('user_id', $this->user()->id)
            ->where('id',$id)
            ->firstOrFail();
        return $this->response->item($order,new OrderTransformer());
    }
    public function store(OrderRequest $request)
    {
        $user  = $request->user();

        // 开启一个数据库事务
        $order = \DB::transaction(function () use ($user, $request) {
            $address = UserAddress::find($request->input('address_id'));
            // 创建一个订单
            $order   = new Order([
                'address'      => [ // 将地址信息放入订单中
                    'address'       => $address->full_address,
                    'contact_name'  => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'remark'       => $request->input('remark'),
                'total_amount' => 0, //订单总金额

            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            // 写入数据库
            $order->save();

            $totalAmount = 0;
            $items       = $request->input('items');

            // 遍历用户提交的 SKU
            foreach ($items as $data) {
                $sku  = Product::find($data['product_id']);
                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
                    'amount' => $data['amount'],
                    'price'  => $sku->price,
                ]);
                $item->product()->associate($data['product_id']);
                $item->save();

                $totalAmount += $sku->price * $data['amount'];
                if ($sku->decreaseStock($data['amount']) <= 0) {
                    throw new \ErrorException('该商品库存不足');
                }
            }

            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            // 将下单的商品从购物车中移除
            $productId = collect($items)->pluck('product_id');
            $user->cartItems()->whereIn('product_id', $productId)->delete();
            return $this->response->created();
        });
        return $this->response->created();

    }
    
    // 取消
    public function close($id)
    {
        $this->user()->orders()->where('user_id',$this->user()->id)->where('id',$id)->update([
            'ship_status' => 'close'
        ]);
        return $this->response->created();
    }
    
    // 确认收获
    public function confirm($id)
    {
        $this->user()->orders()->where('user_id',$this->user()->id)->where('id',$id)->update([
            'ship_status' => 'received'
        ]);
        return $this->response->created();
    }
}
