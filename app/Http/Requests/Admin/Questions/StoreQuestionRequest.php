<?php

namespace App\Http\Requests\Admin\Questions;

use App\Services\Question\QuestionSerivce;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function __construct(private QuestionSerivce $questionSerivce)
    {
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
            'question' => ['required', 'string'],
            'choices' => ['required', 'array'],
            'answer' => ['required', 'integer'],
        ];
    }

    public function prepareForInsert(int $questionnaire_id): array
    {
        return $this->safe()
            ->merge([
                'questionnaire_id' => $questionnaire_id,
                'priority' => $this->questionSerivce->getMaxPriority($questionnaire_id),
                'choices' => serialize($this->safe()->choices),
            ])
            ->toArray();
    }
}
