<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'type_coupon' => 'required|string|min:3|max:30',
			'description' => 'string|min:3|max:255',
			'usage_limit' => 'required|integer|min:0',
			'times_claimed' => 'required|integer|min:0',
			'expiration_date' => 'required|date|after_or_equal:today',
        ];
    }
}