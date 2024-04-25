<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\Admin\QuestionnaireResource;
use App\Interfaces\Question\QuestionRepositoryInterface;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Http\Requests\Admin\Questionnaires\StoreQuestionnaireRequest;
use App\Http\Requests\Admin\Questions\UpdateQuestionsPriorityRequest;
use App\Http\Requests\Admin\Questionnaires\UpdateQuestionnaireRequest;
use App\Http\Requests\Admin\Questionnaires\SearchQuestionnairesRequest;

class QuestionnairesController extends Controller
{
    public function __construct(
        private QuestionnaireRepositoryInterface $questionnaireRepository,
        private QuestionRepositoryInterface $questionRepository
    ) {
    }

    public function index(SearchQuestionnairesRequest $request): InertiaResponse
    {
        $questionnaires = $this->questionnaireRepository->getQuestionnaires($request->validated(), 30);
        $questionnaire_resources = QuestionnaireResource::collection($questionnaires);

        return Inertia::render('Admin/Questionnaires/Index', [
            'questionnaires' => $questionnaire_resources,
            'status' => session('status'),
            'query_params' => $request->validated() ?: null,
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Admin/Questionnaires/Create');
    }

    public function store(StoreQuestionnaireRequest $request): RedirectResponse
    {
        $questionnaire = $this->questionnaireRepository->storeQuestionnaire($request->prepareForInsert());

        return redirect()
            ->route('admin.questionnaires.edit', $questionnaire->id)
            ->with('status', 'Success!');
    }

    public function edit(Questionnaire $questionnaire): InertiaResponse
    {
        $questionnaire->loadMissing('questions');

        return Inertia::render('Admin/Questionnaires/Edit', [
            'questionnaire' => QuestionnaireResource::make($questionnaire),
            'status' => session('status'),
            'question_status' => session('question_status'),
        ]);
    }

    public function update(Questionnaire $questionnaire, UpdateQuestionnaireRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->questionnaireRepository->updateQuestionnaire($questionnaire, $data);

        return redirect()
            ->route('admin.questionnaires.edit', $questionnaire->id, 303)
            ->with('status', 'Success!');
    }

    public function destroy(Questionnaire $questionnaire): RedirectResponse
    {
        $this->questionnaireRepository->deleteQuestionnaire($questionnaire);

        return redirect()
            ->route('admin.questionnaires.index')
            ->with('status', 'Success!');
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
            ->route('admin.questionnaires.reindex', $questionnaire->id, 303)
            ->with('status', 'Success!');
    }
}
