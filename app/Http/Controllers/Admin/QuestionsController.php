<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Helpers\Question\QuestionHelper;
use App\Http\Resources\QuestionResource;
use Inertia\Response as InertiaResponse;
use App\Interfaces\Question\QuestionRepositoryInterface;
use App\Http\Requests\Admin\Questions\StoreQuestionRequest;
use App\Http\Requests\Admin\Questions\UpdateQuestionRequest;
use App\Http\Requests\Admin\Questions\SearchQuestionsRequest;
use App\Http\Requests\Admin\Questions\UpdateQuestionsPriorityRequest;

class QuestionsController extends Controller
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {
    }

    public function store(Questionnaire $questionnaire, StoreQuestionRequest $request): RedirectResponse
    {
        $question = $this->questionRepository->storeQuestion($request->prepareForInsert($questionnaire->id));

        return redirect()
            ->route('admin.questionnaires.edit', $question->questionnaire_id, 303)
            ->with('question_status', 'Success!');
    }

    public function edit(Question $question): InertiaResponse
    {
        return Inertia::render('Admin/Questions/Edit', [
            'questionnaire' => $question,
            'status' => session('status'),
        ]);
    }

    public function update(Question $question, UpdateQuestionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->questionRepository->updateQuestion($question, $data);

        return redirect()
            ->route('admin.questions.edit', $question->id, 303)
            ->with('status', 'Success!');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->questionRepository->deleteQuestion($question);

        $this->questionRepository->updateQuestionsPriority(QuestionHelper::prepareDataForUpdatingPriority($question->questionnaire_id));

        return redirect()
            ->route('admin.questionnaires.edit', $question->questionnaire_id, 303)
            ->with('question_status', 'Success!');
    }

    public function reindex(Questionnaire $questionnaire): InertiaResponse
    {
        $questionnaire->loadMissing([
            'questions' => fn($query) =>
                $query->select([
                    'id',
                    'questionnaire_id',
                    'question',
                    'priority',
                ])
                    ->orderBy('priority')
        ]);

        return Inertia::render('Admin/Questions/ReIndexQuestions', [
            'questionnaire' => $questionnaire,
            'status' => session('status'),
        ]);
    }

    public function updatePriority(Questionnaire $questionnaire, UpdateQuestionsPriorityRequest $request): RedirectResponse
    {
        $this->questionRepository->updateQuestionsPriority($request->safe()->question_ids);

        return redirect()
            ->route('admin.questions.reindex', $questionnaire->id, 303)
            ->with('status', 'Success!');
    }
}
