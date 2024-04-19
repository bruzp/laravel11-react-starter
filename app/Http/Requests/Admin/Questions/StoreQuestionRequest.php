<?php

namespace App\Http\Requests\Admin\Questions;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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

    public function prepareForInsert(int $questionnaire_id): array
    {
        $max_priority = Question::where('questionnaire_id', $questionnaire_id)->max('priority');

        return $this->safe()
            ->merge([
                'questionnaire_id' => $questionnaire_id,
                'priority' => $max_priority ? $max_priority + 1 : 1,
                'choices' => serialize($this->safe()->choices),
            ])
            ->toArray();
    }
}
