<?php

namespace App\Http\Requests\Frontend\Questionnaires;

use Illuminate\Foundation\Http\FormRequest;

class SearchQuestionnairesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'order_by' => ['nullable', 'string', 'in:id,title,description,created_at,updated_at'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }
}
