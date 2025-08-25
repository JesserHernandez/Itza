<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'movement' => 'required|string|min:3|max:10',
			'type_movement' => 'required|string|min:3|max:20',
			'quantity' => 'required|integer|min:0',
			'date' => 'required|date|after_or_equal:today',
			'observation' => 'string|min:3|max:255',
			'inventory_id' => 'required|exists:inventories,id',
			'user_id' => 'required|exists:users,id',
        ];
    }
}
