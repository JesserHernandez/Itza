<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponseReviewRequest extends FormRequest
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
			'photo_path' => 'string|image|max:2048|mimes:jpeg,png,jpg,svg',
			'like_count' => 'required|integer|min:0',
			'dis_like_count' => 'required|integer|min:0',
			'is_verified_purchase' => 'required|boolean',
			'review_id' => 'required|exists:users,id',
        ];
    }
}