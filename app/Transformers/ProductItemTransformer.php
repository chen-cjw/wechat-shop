<?php
namespace App\Transformers;
use App\Captcha;
use App\Models\Product;
use App\Models\User;
use League\Fractal\TransformerAbstract;
class ProductItemTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'on_sale' => $product->on_sale,
            'sold_count' => $product->sold_count,
            'review_count' => $product->review_count,
            'price' => $product->price,
            'category_id' => $product->category_id,
            'openid' => auth('api')->user() ? auth('api')->user()->openid : null,
            'created_at' => $product->created_at->timestamp,
            'updated_at' => $product->updated_at->timestamp,
        ];
    }
}