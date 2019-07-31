<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Transformers\ProductItemTransformer;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // 搜索 + 分类商品
    public function index(Request $request,$id)
    {
        $query = Product::query()->select('title','image','on_sale','sold_count','price','category_id');
        if($id) {
            $query->where('category_id',$id);
        }
        if($request->title) {
            $query->where('title','%'.$request->title.'%');
        }

        $product = $query->paginate(16);
        return $this->response->paginator($product,new ProductTransformer());
    }

    // 详情
    public function show($id)
    {
        $productItem = Product::findOrFail($id);
        return $this->response->item($productItem,new ProductItemTransformer());
    }
}
