<?php

namespace App\Http\Requests\Frontend\Questionnaires;

use App\Models\Questionnaire;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\Questionnaire\QuestionnaireService;
use App\Interfaces\Question\QuestionRepositoryInterface;

class StoreQuestionnairesRequest extends FormRequest
{
    public function __construct(
        private QuestionnaireService $questionnaireService,
        private QuestionRepositoryInterface $questionRepository,
    ) {
    }

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
        $questions = $this->questionRepository->getQuestions([
            'questionnaire_id' => $questionnaire->id,
        ]);

        return [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => auth()->user()->id,
            'answers' => serialize($this->safe()->answers),
            'result' => $this->questionnaireService->checkExam($this->safe()->answers, $questionnaire->questions),
            'questionnaire_data' => serialize($questionnaire->questions->toArray()),
        ];
    }
}
