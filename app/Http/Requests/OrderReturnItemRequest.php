<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderReturnItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'quantity' => 'required|integer|min:0',
			'product_status' => 'required|string|min:3|max:20',
			'is_returned_physical' => 'required|boolean',
			'order_return_id' => 'required|exists:order_returns,id',
			'order_detail_id' => 'required|exists:order_details,id',
        ];
    }
}