<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'amount_paid' => 'required|numeric|min:0',
			'payment_reference' => 'required|string|min:3|max:20',
			'payment_status' => 'required|string|min:3|max:20',
			'payment_date' => 'required|date|after_or_equal:today',
			'payment_method_user_id' => 'required|exists:payment_method_users,id',
			'order_id' => 'required|exists:orders,id',
        ];
    }
}