<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Question\QuestionSerivce;
use App\Interfaces\Question\QuestionRepositoryInterface;
use App\Http\Requests\Admin\Questions\StoreQuestionRequest;
use App\Http\Requests\Admin\Questions\UpdateQuestionRequest;

class QuestionsController extends Controller
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private QuestionSerivce $questionSerivce
    ) {
    }

    public function store(Questionnaire $questionnaire, StoreQuestionRequest $request): RedirectResponse
    {
        $question = $this->questionRepository->storeQuestion($request->prepareForInsert($questionnaire->id));

        return redirect()
            ->route('admin.questionnaires.edit', $question->questionnaire_id, 303)
            ->with('question_status', 'Success!');
    }

    public function update(Question $question, UpdateQuestionRequest $request): RedirectResponse
    {
        $this->questionRepository->updateQuestion($question, $request->prepareForInsert());

        return redirect()
            ->route('admin.questionnaires.edit', $question->questionnaire_id, 303)
            ->with('question_status', 'Success!');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->questionRepository->deleteQuestion($question);

        $data = $this->questionSerivce->prepareDataForUpdatingPriority($question->questionnaire_id);

        if ($data) {
            $this->questionRepository->updateQuestionsPriority($data);
        }

        return redirect()
            ->route('admin.questionnaires.edit', $question->questionnaire_id, 303)
            ->with('question_status', 'Success!');
    }
}
