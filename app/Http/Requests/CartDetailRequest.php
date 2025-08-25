<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartDetailRequest extends FormRequest
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
			'product_id' => 'required|exists:products,id',
			'cart_id' => 'required|exists:carts,id',
        ];
    }
}