<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
			'surname' => 'required|string|min:3|max:50',
			'email' => 'string|min:3|max:50',
			'password' => 'string|min:8',
			'status' => 'string|min:3|max:20',
			'gender' => 'required|string|min:3|max:10',
			'phone_number' => 'required|string|min:3|max:20',
			'identification_card' => 'required|string|min:3|max:20',
			'profile_photo_url' => 'image|max:2048|mimes:jpeg,png,jpg,svg',

            'roles' => 'required|array|min:1',
        ];
    }
}