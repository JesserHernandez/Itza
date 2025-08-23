<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'is_main' => 'required|boolean',
			'product_id' => 'required|exists:products,id',
			'product_material_id' => 'required|exists:product_materials,id',
        ];
    }
}