<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'type' => 'required|string|min:3|max:20',
			'name' => 'required|string|min:3|max:20',
			'description' => 'required|text|min:3',
			'company_name' => 'required|string|min:3|max:30',
			'schedule' => 'required|string|min:3|max:100',
			'email' => 'string|min:3|max:50',
			'price_range' => 'required|string|min:3|max:30',
			'phone_number' => 'required|string|min:3|max:20',
			'photo_path' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
			'creative_circuit_id' => 'required|exists:creative_circuits,id',
        ];
    }
}