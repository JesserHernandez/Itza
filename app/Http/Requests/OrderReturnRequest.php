<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'title' => 'required|string|min:3|max:100',
			'content' => 'required|string|min:3',
			'application_date' => 'required|date|after_or_equal:today',
			'order_id' => 'required|exists:orders,id',

			'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|integer|min:0',
			'items.*.product_status' => 'required|string|min:3|max:20',
			'items.*.is_returned_physical' => 'required|boolean',
			'items.*.order_return_id' => 'required|exists:order_returns,id',
			'items.*.order_detail_id' => 'required|exists:order_details,id',
        ];
    }
}