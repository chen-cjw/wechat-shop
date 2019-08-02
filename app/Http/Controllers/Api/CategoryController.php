<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::orderBy('sort_num','desc')->get();
        return $this->response->collection($category,new CategoryTransformer());
    }


}
