<?php

namespace App\Http\Requests\Admin\Questions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'question' => ['required', 'string'],
            'choices' => ['required', 'array'],
            'answer' => ['required', 'integer'],
        ];
    }

    public function prepareForInsert(): array
    {
        return $this->safe()
            ->merge([
                'choices' => serialize($this->safe()->choices),
            ])
            ->toArray();
    }
}
