<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['amount', 'price'];
    protected $dates = ['reviewed_at'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
