<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name"          => "required|max:200",
            "slug"          => "required|max:200|regex:/^\S*$/|unique:products,slug",
            "ean"           => "nullable|string",
            "price"         => "required|max:8|regex:/^\\d*(\\.\\d{1,2})?$/",
            "saleprice"     => "nullable|max:13|regex:/^\\d*(\\.\\d{1,2})?$/",
            "tax"           => "nullable|max:13|regex:/^\\d*(\\.\\d{1,2})?$/",
            "sku"           =>  "required|max:200",
            "quantity"      => "nullable|integer",
            "description"   => "nullable",
            "details"       => "nullable",
            "image"         => "nullable|mimes:jpg,jpeg,png",
            "images.*"      => "nullable|mimes:jpg,jpeg,png",
            "height"        => "nullable",
            "width"         => "nullable",
            "length"        => "nullable",
            "weight"        => "nullable",
            "is_variable" => "nullable",
            "status" => "nullable",
            "featured" => "nullable",

        ];
    }
}
