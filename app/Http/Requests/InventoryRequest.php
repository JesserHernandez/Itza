<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'initial_existence' => 'required|integer|min:0',
			'current_balance' => 'required|integer|min:0',
			'minimum_balance' => 'required|integer|min:0',
			'balancing_status' => 'required|string|min:3|max:20',
			'product_id' => ['required','exists:products,id',Rule::unique('inventories', 'product_id')->ignore($this->route('inventory')?->id ?? $this->route('inventory'))],
			'team_id' => 'required|exists:teams,id',

            'movement' => 'required|string|min:3|max:10',
			'type_movement' => 'required|string|min:3|max:20',
			'quantity' => 'required|integer|min:0',
			'date' => 'required|date|after_or_equal:today',
			'observation' => 'string|min:3|max:255',
			'inventory_id' => 'required|exists:inventories,id',
        ];
    }
}