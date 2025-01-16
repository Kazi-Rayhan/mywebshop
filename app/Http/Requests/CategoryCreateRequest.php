<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'name' => 'required',
            'slug' => 'required|unique:App\Models\Category,slug,'.$this->category,
            'category' => 'nullable|exists:App\Models\Category,id',
        ];
    }
}
