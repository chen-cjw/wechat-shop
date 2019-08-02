<?php

namespace App\Models;

use Dingo\Api\Exception\InternalHttpException;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'on_sale', 'stock', 'sold_count', 'price','category_id','type'
    ];
    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一个布尔类型的字段
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // 与商品SKU关联
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            throw new \ErrorException('减库存不可小于0');
        }

        return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount)
    {
        if ($amount < 0) {
            throw new \ErrorException('加库存不可小于0');
        }
        $this->increment('stock', $amount);
    }
}
