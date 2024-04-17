<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\QuestionnaireResource;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Http\Requests\Admin\Questionnaires\StoreQuestionnaireRequest;
use App\Http\Requests\Admin\Questionnaires\UpdateQuestionnaireRequest;
use App\Http\Requests\Admin\Questionnaires\SearchQuestionnairesRequest;

class QuestionnairesController extends Controller
{
    public function __construct(private QuestionnaireRepositoryInterface $questionnaireRepository)
    {
    }

    public function index(SearchQuestionnairesRequest $request): InertiaResponse
    {
        return Inertia::render('Admin/Questionnaires/Index', [
            'questionnaires' => QuestionnaireResource::collection($this->questionnaireRepository->getQuestionnaires(30, $request->validated())),
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
}
