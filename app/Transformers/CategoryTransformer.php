<?php
namespace App\Transformers;
use App\Models\Category;
use League\Fractal\TransformerAbstract;
class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'title' => $category->title,
            'image' => config('app.url').'/storage/'.$category->image,
            'sort_num' => $category->sort_num,
            'openid' => auth('api')->user() ? auth('api')->user()->openid : null,
            'created_at' => $category->created_at->toDateTimeString(),
            'updated_at' => $category->updated_at->toDateTimeString(),
        ];
    }
}