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
			'description' => 'required|string|min:3',
			'status' => 'required|string|min:3|max:20',
			'physical_location' => 'string|min:3|max:20',
			'creator' => 'required|string|min:3|max:100',
			'creation_date' => 'required|date|before_or_equal:today',
			'price' => 'required|numeric|min:0',
			'team_id*' => 'required|exists:teams,id',

            'category_attributes' => 'required|array|min:1',
            'category_attributes.*.id' => 'required|exists:category_attributes,id',
            'category_attributes.*.product_id' => 'required|exists:products,id',
            'category_attributes.*.value' => 'required',

			'tags' => 'required|array|min:1',
			'tags.*' => 'required|exists:tags,id',

            'categories' => 'required|array|min:1',
			'categories.*' => 'required|exists:categories,id',

            'photo_paths' => 'required|array|min:1',
			'photo_paths.*' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
        ];
    }
}