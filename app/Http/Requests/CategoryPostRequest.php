<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
			'category_id' => 'required|exists:categories,id',
        ];
    }
}