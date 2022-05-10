<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends SendErrorsRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'subtitle' => ['required', 'max:255'],
            'body' => ['required', 'max:10000'],
            'cover' => ['required','image', 'mimes:png,jpeg,bmp', 'max:4096']
        ];
    }
}
