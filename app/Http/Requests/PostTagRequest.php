<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:post,id',
			'tag_id' => 'required|exists:tags,id',
        ];
    }
}