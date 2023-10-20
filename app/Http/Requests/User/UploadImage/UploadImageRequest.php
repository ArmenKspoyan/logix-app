<?php

namespace App\Http\Requests\User\UploadImage;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachment' => 'required|mimes:jpg,png,svg,pdf',
        ];
    }
}
