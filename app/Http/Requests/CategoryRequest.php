<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'name' => ['required','string','min:3','max:20', Rule::unique('users')->ignore($this->route('user')) ],
			'description' => 'string|min:3|max:255',

            'category_attributes' => 'required|array|min:1',
            'category_attributes.*.category_name' => 'required',
            'category_attributes.*.label' => 'required',
            'category_attributes.*.data_type' => 'required',
            'category_attributes.*.unit' => 'required',
        ];
    }
}