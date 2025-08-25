<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerificationUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'status' => 'required|string|min:3|max:20',
			'submitted_documents' => 'required',
			'comments' => 'string|min:3|max:255',
        ];
    }
}