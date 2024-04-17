<?php

namespace App\Http\Requests\Admin\Questions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionsPriorityRequest extends FormRequest
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
            '*.id' => ['required', 'integer'],
            // '*.questionnaire_id' => ['required', 'integer'],
            // '*.question' => ['required', 'string'],
            // '*.priority' => ['required', 'integer'],
        ];
    }
}
