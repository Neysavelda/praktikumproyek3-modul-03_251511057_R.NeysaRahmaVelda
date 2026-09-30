<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title'         => ['required', 'string', 'min:5', 'max:100'],
            'description'   => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'status'        => ['required', 'in:Planned,Ongoing,Done'],
        ];
    }
}