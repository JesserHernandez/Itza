<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'title' => 'required|string|min:3|max:100',
			'rating' => 'required|integer|min:0',
			'comment' => 'required|string|min:3',
			'review_date' => 'required|date|after_or_equal:today',
            'photo_path' => 'string|image|max:2048|mimes:jpeg,png,jpg,svg',
            'reviewed_type' => 'required|string|in:App\\Models\\Product,App\\Models\\Post,App\\Models\\Team', 
            'reviewed_id' => 'required|integer'
        ];
    }
}