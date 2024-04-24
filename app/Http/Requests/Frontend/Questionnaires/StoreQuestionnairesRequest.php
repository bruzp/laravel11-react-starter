<?php

namespace App\Http\Requests\Frontend\Questionnaires;

use App\Models\Questionnaire;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\Questionnaire\QuestionnaireService;

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

    public function prepareForInsert(Questionnaire $questionnaire): array
    {
        return [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => auth()->user()->id,
            'answers' => serialize($this->safe()->answers),
            #TODO: Change to non-static method
            'result' => QuestionnaireService::checkExam($this->safe()->answers, $questionnaire->questions),
            'questionnaire_data' => serialize($questionnaire->questions->toArray()),
        ];
    }
}
