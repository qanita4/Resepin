<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment' => [
                'required',
                'string',
                'max:2000',
                'not_regex:/<\\s*script\\b/i',
            ],
        ];
    }
}
