<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\Admin\QuestionnaireResource;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Http\Requests\Frontend\Questionnaires\SearchQuestionnairesRequest;

class QuestionnaireController extends Controller
{
    public function __construct(private QuestionnaireRepositoryInterface $questionnaireRepository)
    {
    }

    public function index(SearchQuestionnairesRequest $request): InertiaResponse
    {
        return Inertia::render('Frontend/Questionnaire/Index', [
            'questionnaires' => QuestionnaireResource::collection($this->questionnaireRepository->getQuestionnaires(30, $request->validated())),
            'query_params' => $request->validated() ?: null,
        ]);
    }
}
