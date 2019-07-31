<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $orderBy = $request->input('sort','asc');
        $category = Category::orderBy('sort_num',$orderBy)->get();
        return $this->response->collection($category,new CategoryTransformer());
    }


}
