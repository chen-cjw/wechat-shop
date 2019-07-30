<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // 搜索
    public function index(Request $request)
    {

        $product = Product::where('title','%'.$request->title.'%')->paginate();
        return $product;
    }
}
