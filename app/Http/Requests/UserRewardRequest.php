<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRewardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'points' => 'required|integer|min:0',
			'points_expiration' => 'required|date|after_or_equal:today',
			'reason' => 'string|min:3|max:255',
        ];
    }
}