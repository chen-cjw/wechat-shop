<?php
namespace App\Transformers;
use App\Captcha;
use App\Models\Product;
use App\Models\User;
use League\Fractal\TransformerAbstract;
class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'title' => $product->title,
            'on_sale' => $product->on_sale,
            'sold_count' => $product->sold_count,
            'review_count' => $product->review_count,
            'price' => $product->price,
            'category_id' => $product->category_id,
        ];
    }
}