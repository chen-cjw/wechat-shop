<?php
namespace App\Transformers;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use League\Fractal\TransformerAbstract;
class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'no' => $order->no,
            'address' => $order->address,
            'total_amount' => $order->total_amount,
            'remark' => $order->remark,
            'ship_status' => $order->ship_status,
            'created_at' => $order->created_at->timestamp,
            'updated_at' => $order->updated_at->timestamp,
            'items' => $order->items,

        ];
    }
}