<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'name' => 'required|string|min:3|max:30',

			'permissions' => 'required|array|min:1',
			'permissions.*' => 'required|exists:permissions,id',
        ];
    }
}
