<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'name' => ['required','string','min:3','max:20', Rule::unique('product_materials')->ignore($this->route('product_material')) ],
			'description' => 'string|min:3|max:255',
        ];
    }
}