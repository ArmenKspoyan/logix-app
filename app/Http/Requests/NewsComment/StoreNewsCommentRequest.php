<?php

namespace App\Http\Requests\NewsComment;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:news,id',
            'text' => 'required|min:1|max:1000',
        ];
    }
}
