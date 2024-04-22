<?php

namespace App\Http\Requests\Admin\Answer;

use Illuminate\Foundation\Http\FormRequest;

class SearchAnswersRequest extends FormRequest
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
            'order_by' => ['nullable', 'string', 'in:id,name,email,title,description,result,created_at,updated_at'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }
}
