<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class ManagerCreateRequest extends FormRequest
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
            'managers.*.first_name' => 'required',
            'managers.*.last_name' => 'required',
            'managers.*.email' => ['required', 'email', 'unique:users,email'],
            'managers.*.phone' => 'required',
            'managers.*.photo' => ['nullable', 'mimes:jpeg,jpg,png', 'max:10000'],
            'managers.*.tax' => 'nullable',
            'managers.*.password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'managers.*.first_name.required' => 'First name for manager is missing',
            'managers.*.last_name.required' => 'Last name for manager is missing',
            'managers.*.phone.required' => 'Phone from manager is missing',
            'managers.*.tax.required' => 'Tax from for manager is missing',
            'managers.*.email.required' => 'Email for manager is missing',
            'managers.*.email.email' => 'Invalid email format',
            'managers.*.email.unique' => 'Email already exists',
            'managers.*.password.required' => 'Password for manager is missing',
        ];
    }
}
