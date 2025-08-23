<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'quantity' => 'required|integer|min:0',
			'price_at_time' => 'required|numeric|min:0',
			'order_id' => 'required|exists:orders,id',
			'product_id' => 'required|exists:products,id',
        ];
    }
}