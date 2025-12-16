<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
			'title' => 'required|string|min:3|max:50',
			'type' => 'required|string|min:3|max:20',
			'content' => 'required|string|min:3',
			'status' => 'required|string|min:3|max:20',
			'report_date' => 'required|date|after_or_equal:today',
        ];
    }
}