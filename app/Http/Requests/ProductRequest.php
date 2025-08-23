<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'code' => 'required|string|min:3|max:20',
			'name' => 'required|string|min:3|max:30',
			'technique' => 'string|min:3|max:255',
			'cultural_origin' => 'string|min:3|max:255',
			'dimensions' => 'required|string|min:3|max:50',
			'color' => 'required|string|min:3|max:20',
			'shape' => 'required|string|min:3|max:20',
			'history' => 'required|string|min:3',
			'status' => 'required|string|min:3|max:20',
			'physical_location' => 'string|min:3|max:20',
			'creator' => 'required|string|min:3|max:100',
			'creation_date' => 'required|date|before_or_equal:today',
			'price' => 'required|numeric|min:0',

			'materials' => 'required|array|min:1',
			'materials.*.id' => 'required|exists:product_materials,id',
			'materials.*.is_main' => 'required|boolean',

			'tags' => 'required|array|min:1',
			'tags.*' => 'required|exists:tags,id',
			'tags.*.is_main' => 'required|boolean',

            'categories' => 'required|array|min:1',
			'categories.*' => 'required|exists:categories,id',
			'categories.*.is_main' => 'required|boolean',

            'images' => 'required|array|min:1',
			'images.*.photo_path' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
			'images.*.is_main' => 'required|boolean',
        ];
    }
}