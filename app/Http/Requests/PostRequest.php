<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'title' => 'required|string|min:3|max:100',
			'content' => 'required|text|min:3',
			'summary' => 'required|string|min:3|max:255',
			'post_status' => 'required|string|min:3|max:20',
			'post_date' => 'required|date|after_or_equal:today',

            'tags' => 'required|array|min:1',
			'tags.*' => 'required|exists:tags,id',

            'categories' => 'required|array|min:1',
			'categories.*' => 'required|exists:categories,id',

            'images' => 'required|array|min:1',
			'images.*.photo_path' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
			'images.*.is_main' => 'required|boolean',
        ];
    }
}