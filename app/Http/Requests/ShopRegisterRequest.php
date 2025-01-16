<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ShopRegisterRequest extends FormRequest
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_name' => Str::slug($this->company_name, ''),
        ]);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'user_name' => ['required', 'string', 'max:30', 'alpha_num', 'unique:shops,user_name'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'company_name' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return  [
            'user_name.regex' => 'User name can not contain whitespace.',
            'user_name.unique' => 'User name allready exists, try something different .',
        ];
    }
}
