<?php
namespace App\Transformers;
use App\Models\Banner;
use League\Fractal\TransformerAbstract;
class BannerTransformer extends TransformerAbstract
{

    public function transform(Banner $banner)
    {
        return [
            'id' => $banner->id,
            'image' => $banner->image,
            'url' => $banner->url,
        ];
    }
}