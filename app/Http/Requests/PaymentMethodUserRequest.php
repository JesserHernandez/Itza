<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'method_name' => 'required|string|min:3|max:100',
			'provider' => 'required|string|min:3|max:10',
			'type' => 'required|string|min:3|max:15',
			'currency_supported' => 'required|string|min:3|max:15',
			'card_numberLast4' => 'nullable|string|min:3|max:20',
			'expiration_month' => 'nullable|string|min:3|max:10',
			'expiration_year' => 'nullable|string|min:3|max:10',
			'photo_path' => 'string|image|max:2048|mimes:jpeg,png,jpg,svg',
        ];
    }
}