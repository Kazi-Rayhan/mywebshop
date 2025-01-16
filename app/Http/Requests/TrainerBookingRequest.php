<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerBookingRequest extends FormRequest
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
        $rules = [
            'tax' => 'required|numeric',
            'sub_price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'package' => 'required',
            'trainer' => 'required',
            'split' => 'nullable',
        ];

        if (auth()->check() == false) {
            $rules['user.*'] = 'required';
            if (isset($this->user['register'])) {
                $rules['user.register.name'] = ['required', 'string', 'max:255'];
                $rules['user.register.last_name'] = ['required', 'string', 'max:255'];
                $rules['user.register.phone'] = ['required', 'string', 'max:255'];
                $rules['user.register.email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email'];
                $rules['user.register.password'] = ['required', 'string', 'min:8'];
            }
            if (isset($this->user['login'])) {
                $rules['user.login.email'] = ['required', 'email'];
                $rules['user.login.password'] = ['required'];
            }
        }
        return $rules;
    }
}
