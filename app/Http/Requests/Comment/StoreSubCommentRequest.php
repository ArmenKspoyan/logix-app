<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment_id' => 'required|integer|exists:comments,id',
            'text' => 'required|min:1|max:1000',
        ];
    }
}
