<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'tag_id' => 'required|exists:tags,id',
			'product_id' => 'required|exists:products,id',
        ];
    }
}