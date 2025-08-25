<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddresseUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'type' => 'required|string|min:3|max:15',
			'address' => 'required|string|min:3|max:255',
			'postal_code' => 'required|string|min:3|max:10',
			'city' => 'required|string|min:3|max:20',
			'municipality' => 'required|string|min:3|max:20',
			'is_main' => 'required|boolean',
        ];
    }
}