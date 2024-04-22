<?php

namespace App\Http\Requests\User\Answer;

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
            'order_by' => ['nullable', 'string', 'in:id,title,description,result,created_at,updated_at'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function prepareForSearch(): array
    {
        return $this->safe()
            ->merge(['user_id' => $this->user()->id])
            ->toArray();
    }
}
