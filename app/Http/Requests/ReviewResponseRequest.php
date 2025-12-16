<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'comment' => 'required|string|min:3',
			'review_date' => 'required|date|after_or_equal:today',
			'like_count' => 'required|integer|min:0',
			'dis_like_count' => 'required|integer|min:0',
			'is_verified_purchase' => 'required|boolean',
			'review_id' => 'required|exists:reviews,id',

            'images' => 'array|min:1',
            'images.*.photo_path' => 'string|image|max:2048|mimes:jpeg,png,jpg,svg',
            'images.*.review_type' => 'string|in:App\\Models\\Review,App\\Models\\ReviewResponse', 
            'images.*.review_id' => 'integer'
        ];
    }
}