<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreativeCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3|max:30',
			'description' => 'required|string|min:3',
			'specialty' => 'required|string|min:3|max:20',
			'region' => 'required|string|min:3|max:20',
			'latitude' => 'required|string|min:3|max:30',
			'longitude' => 'required|string|min:3|max:30',
			'photo_path' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
        ];
    }
}
