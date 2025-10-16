<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WishlistsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    public function rules(): array
    {
        return [
			'product_id' => ['required','exists:products,id',Rule::unique('wishlists', 'product_id')->ignore($this->route('wishlist')?->id ?? $this->route('wishlist'))],
        ];
    }
}