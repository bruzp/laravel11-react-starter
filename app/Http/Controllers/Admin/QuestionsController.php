<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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

    public function index(SearchQuestionsRequest $request): InertiaResponse
    {
        return Inertia::render('Admin/Questions/Index', [
            'questions' => QuestionResource::collection($this->questionRepository->getQuestions(30, $request->validated())),
            'status' => session('status'),
            'query_params' => $request->validated() ?: null,
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Admin/Questions/Create');
    }

    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        $question = $this->questionRepository->storeQuestion($request->prepareForInsert());

        return redirect()
            ->route('admin.questions.edit', $question->id)
            ->with('status', 'Success!');
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

        $this->questionRepository->reIndexPriority($question->questionnaire_id);

        return redirect()
            ->route('admin.questionnaires.edit', $question->questionnaire_id, 303)
            ->with('question_status', 'Success!');
    }

    public function reindex(Questionnaire $questionnaire): InertiaResponse
    {
        $questionnaire->loadMissing([
            'questions' => fn($query) => $query->select([
                'id',
                'questionnaire_id',
                'question',
                'priority',
            ])
        ]);

        return Inertia::render('Admin/Questions/ReIndexQuestions', [
            'questionnaire' => $questionnaire,
        ]);
    }

    public function updatePriority(Questionnaire $questionnaire, UpdateQuestionsPriorityRequest $request):RedirectResponse
    {
        dd($questionnaire, $request->all(), $request->validated());
    }
}
