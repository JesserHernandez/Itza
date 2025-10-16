<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'is_like' => 'required|boolean',
			'is_dis_like' => 'required|boolean',
            'liked_type' => 'required|string|in:App\\Models\\ResponseReview,App\\Models\\Review', 
            'liked_id' => 'required|integer'
        ];
    }
}