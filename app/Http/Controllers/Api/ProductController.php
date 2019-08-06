<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Transformers\ProductItemTransformer;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // 分类商品
    public function index(Request $request,$id)
    {

        $product = Product::query()->select('id','title','image','on_sale','stock','sold_count','price','category_id','type')
                    ->where('category_id',$id)->where('on_sale',1);
        // 销量
        if($sold_count = $request->sold_count_sort) {
            $product->orderBy('sold_count',$sold_count); //$request->sold_count_sort 传 desc 或者 asc
        }elseif ($type = $request->type) {
            $product->where('type',$type);
        }elseif ($price = $request->price_sort) {
            $product->orderBy('price',$price); // $price 传 desc 或者 asc
        }

        $product = $product->paginate(16);
        return $this->response->paginator($product,new ProductTransformer());
    }

    // 详情
    public function show($id)
    {
        $productItem = Product::findOrFail($id);
        return $productItem;
        return $this->response->item($productItem,new ProductTransformer());
    }
}
