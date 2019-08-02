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
            'image' => $product->image,
            'on_sale' => $product->on_sale,
            'sold' => $product->sold,
            'sold_count' => $product->sold_count,
            'price' => $product->price,
            'category_id' => $product->category_id,
            'type' => $product->type,
            'description' => $product->description,
        ];
    }
}