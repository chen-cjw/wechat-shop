<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Transformers\BannerTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::get();
        return $this->response->collection($banners,new BannerTransformer());
    }
}
