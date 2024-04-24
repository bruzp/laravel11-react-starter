<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Questionnaire;
use App\Helpers\Answer\AnswerHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\User\QuestionnaireResource;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Http\Requests\Frontend\Questionnaires\StoreQuestionnairesRequest;
use App\Http\Requests\Frontend\Questionnaires\SearchQuestionnairesRequest;

class QuestionnairesController extends Controller
{
    public function __construct(
        private QuestionnaireRepositoryInterface $questionnaireRepository,
        private AnswerRepositoryInterface $answerRepository
    ) {
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

        return Inertia::render('Frontend/Questionnaires/Create/CreateIndex', [
            'questionnaire' => QuestionnaireResource::make($questionnaire),
            'status' => session('status'),
        ]);
    }

    /**
     * Check exam.
     */
    public function store(Questionnaire $questionnaire, StoreQuestionnairesRequest $request): RedirectResponse
    {
        $questionnaire->loadMissing('questions');

        $data = $request->prepareForInsert($questionnaire);

        $this->answerRepository->storeAnswer($data);

        return redirect()
            ->route('exam-result', [], 303)
            ->with('status', AnswerHelper::examScoreMessage($data['result']));
    }

    public function storeComplete(): InertiaResponse|RedirectResponse
    {
        if (!session()->has('status')) {
            return redirect()->route('exams');
        }

        return Inertia::render('Frontend/Questionnaires/Create/CreateComplete', [
            'status' => session('status'),
        ]);
    }
}
