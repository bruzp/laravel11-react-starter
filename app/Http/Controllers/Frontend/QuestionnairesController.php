<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\User\QuestionnaireResource;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Http\Requests\Frontend\Questionnaires\StoreQuestionnairesRequest;
use App\Http\Requests\Frontend\Questionnaires\SearchQuestionnairesRequest;

class QuestionnairesController extends Controller
{
    public function __construct(private QuestionnaireRepositoryInterface $questionnaireRepository)
    {
    }

    public function index(SearchQuestionnairesRequest $request): InertiaResponse
    {
        return Inertia::render('Frontend/Questionnaires/Index', [
            'questionnaires' => QuestionnaireResource::collection($this->questionnaireRepository->getQuestionnaires(30, $request->validated())),
            'query_params' => $request->validated() ?: null,
        ]);
    }

    /**
     * Display the examination form.
     */
    public function create(Questionnaire $questionnaire): InertiaResponse
    {
        $questionnaire->loadMissing('questions');

        return Inertia::render('Frontend/Questionnaires/Create', [
            'questionnaire' => QuestionnaireResource::make($questionnaire),
            'status' => session('status'),
        ]);
    }

    /**
     * Check exam.
     */
    public function store(Questionnaire $questionnaire, StoreQuestionnairesRequest $request): InertiaResponse
    {
        $questionnaire->loadMissing('questions');

        // create event listener that someone take exam and send email

        dd($questionnaire, $questionnaire->questions, $request->validated(), $request->prepareForInsert($questionnaire));
    }
}
