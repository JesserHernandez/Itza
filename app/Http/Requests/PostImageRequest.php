<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'photo_path' => 'string|image|max:2048|mimes:jpeg,png,jpg,svg',
			'is_main' => 'required|boolean',
			'post_id' => 'required|exists:posts,id',
        ];
    }
}