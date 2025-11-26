<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreativeCircuitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3|max:20',
			'description' => 'required|text|min:3',
			'photo_path' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
			'creative_city_id' => 'required|exists:creative_cities,id',
        ];
    }
}