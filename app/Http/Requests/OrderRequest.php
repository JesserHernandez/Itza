<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'sub_total' => 'required|numeric|min:0',
			'shipping_cost' => 'required|numeric|min:0',
			'total' => 'required|numeric|min:0',
			'shipping_number' => 'nullable|string|min:3|max:20',
			'estimated_time' => 'nullable|string|min:3|max:20',
			'warranty' => 'nullable|string|min:3|max:10',
			'order_date' => 'required|date|after_or_equal:today',
			'addresses_user_id' => 'required|exists:addresse_users,id',

			'products' => 'required|array|min:1',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.quantity' => 'required|integer|min:1',
			'products.*.price_at_time' => 'required|numeric|min:0',

			'payment.amount_paid' => 'required|numeric|min:0',
			'payment.payment_reference' => 'required|string|min:3|max:20',
			'payment.payment_date' => 'required|date|after_or_equal:today',
			'payment.payment_method_user_id' => 'required|exists:payment_method_users,id',
        ];
    }
}