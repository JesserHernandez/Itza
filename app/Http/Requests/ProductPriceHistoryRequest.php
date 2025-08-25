<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPriceHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'old_price' => 'required|numeric|min:0',
			'product_id' => 'required|exists:products,id',
        ];
    }
}