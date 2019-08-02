<?php
namespace App\Transformers;
use App\Models\CartItem;
use League\Fractal\TransformerAbstract;
class CartTransformer extends TransformerAbstract
{
    public function transform(CartItem $cartItem)
    {
        return [
            'id' => $cartItem->id,
            'amount' => $cartItem->amount,
            'product_id' => $cartItem->product_id,
            'user_id' => $cartItem->user_id,
            'product' => $cartItem->product,

        ];
    }
}