<?php

namespace App\Http\Requests\Frontend\Questionnaires;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnairesRequest extends FormRequest
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
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'integer'],
        ];
    }

    public function prepareForInsert(): array
    {
        return [
            'questionnaire_id' => 'xxx',
            'user_id' => 'xxx',
            'answers' => 'xxx',
            'result' => 'xxx',
            'questionnaire_data' => 'xxx',
        ];
    }
}
