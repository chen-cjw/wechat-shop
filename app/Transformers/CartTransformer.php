<?php
namespace App\Transformers;
use App\Models\CartItem;
use League\Fractal\TransformerAbstract;
class CartTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product'];

    public function transform(CartItem $cartItem)
    {
        return [
            'id' => $cartItem->id,
            'amount' => $cartItem->amount,
            'product_id' => $cartItem->product_id,
            'user_id' => $cartItem->user_id,
            'product' => $cartItem->product,
            'openid' => auth('api')->user() ? auth('api')->user()->openid : null,

        ];
    }
    public function includeProduct(CartItem $cartItem)
    {
        return $this->item($cartItem->product, new ProductTransformer());
    }
}