<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:0',
			'operation' => 'required|boolean',
			'price_at_time' => 'required|numeric|min:0',
			'product_id' => ['required','exists:products,id',Rule::unique('carts', 'product_id')->ignore($this->route('cart')?->id ?? $this->route('cart'))],
        ];
    }
}
