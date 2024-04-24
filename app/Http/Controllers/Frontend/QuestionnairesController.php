<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Questionnaire;
use App\Helpers\Answer\AnswerHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Services\Answer\AnswerService;
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
        private AnswerRepositoryInterface $answerRepository,
        private AnswerService $answerService,
    ) {
    }

    public function index(SearchQuestionnairesRequest $request): InertiaResponse
    {
        $questionnaires = $this->questionnaireRepository->getQuestionnaires(30, $request->validated());
        $questionnaire_resources = QuestionnaireResource::collection($questionnaires);
        $queryParams = $request->validated() ?: null;
        $userAnswers = auth()->check()
            ? $this->answerService->getUserAnswers($questionnaires->pluck('id')->all(), auth()->user()->id)
            : [];

        return Inertia::render('Frontend/Questionnaires/Index', [
            'questionnaires' => $questionnaire_resources,
            'query_params' => $queryParams,
            'user_answers' => $userAnswers,
        ]);
    }

    /**
     * Display the examination form.
     */
    public function create(Questionnaire $questionnaire): InertiaResponse
    {
        Gate::authorize('takeExam', $questionnaire);

        $questionnaire->loadMissing('questions');
        $questionnaire_resource = QuestionnaireResource::make($questionnaire);

        return Inertia::render('Frontend/Questionnaires/Create/CreateIndex', [
            'questionnaire' => $questionnaire_resource,
            'status' => session('status'),
        ]);
    }

    /**
     * Check exam.
     */
    public function store(Questionnaire $questionnaire, StoreQuestionnairesRequest $request): RedirectResponse
    {
        Gate::authorize('takeExam', $questionnaire);

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
