<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends SendErrorsRequest
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
            'image' => ['image', 'mimes:png,jpeg,bmp', 'max:2048'],
            'document' => ['file', 'mimes:xlsx,txt,docx']
        ];
    }
}
