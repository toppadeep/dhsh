<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends SendErrorsRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'login' => ['required', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'avatar' => ['image', 'mimes:png,jpeg,bmp', 'max:2048']
        ];
    }
}
