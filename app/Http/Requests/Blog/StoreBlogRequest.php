<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:50',
            'description' => 'required|min:1|max:1000',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'required|mimes:jpg,png,svg,pdf',
        ];
    }
}
