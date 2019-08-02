<?php

namespace App\Http\Requests;


use App\Models\Product;
use Dingo\Api\Http\FormRequest;

class AddCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$product = Product::find($value)) {
                        return $fail('该商品不存在');
                    }
                    if (!$product->on_sale) {
                        return $fail('该商品未上架');
                    }
                    if ($product->stock === 0) {
                        return $fail('该商品已售完');
                    }
                    if ($this->input('amount') > 0 && $product->stock < $this->input('amount')) {
                        return $fail('该商品库存不足');
                    }
                },
            ],
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'amount' => '商品数量'
        ];
    }

    public function messages()
    {
        return [
            'sku_id.required' => '请选择商品'
        ];
    }
}
