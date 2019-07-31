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
            'sort_num' => $category->sort_num,
        ];
    }
}