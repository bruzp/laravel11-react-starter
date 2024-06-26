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
use App\Http\Resources\User\QuestionResource;
use App\Http\Resources\User\QuestionnaireResource;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use App\Interfaces\Question\QuestionRepositoryInterface;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;
use App\Http\Requests\Frontend\Questionnaires\StoreQuestionnairesRequest;
use App\Http\Requests\Frontend\Questionnaires\SearchQuestionnairesRequest;

class QuestionnairesController extends Controller
{
    public function __construct(
        private QuestionnaireRepositoryInterface $questionnaireRepository,
        private AnswerRepositoryInterface $answerRepository,
        private AnswerService $answerService,
        private QuestionRepositoryInterface $questionRepository,
    ) {
    }

    public function index(SearchQuestionnairesRequest $request): InertiaResponse
    {
        $questionnaires = $this->questionnaireRepository->getQuestionnaires($request->validated(), 30);
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
        Gate::authorize('create', $questionnaire);

        $questionnaire_resource = QuestionnaireResource::make($questionnaire);
        $questions = $this->questionRepository->getQuestions([
            'questionnaire_id' => $questionnaire->id,
        ]);
        $questions_resource = QuestionResource::collection($questions);

        return Inertia::render('Frontend/Questionnaires/Create/Index', [
            'questionnaire' => $questionnaire_resource,
            'questions' => $questions_resource,
            'status' => session('status'),
        ]);
    }

    /**
     * Check exam.
     */
    public function store(Questionnaire $questionnaire, StoreQuestionnairesRequest $request): RedirectResponse
    {
        Gate::authorize('create', $questionnaire);

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

        return Inertia::render('Frontend/Questionnaires/Create/Complete', [
            'status' => session('status'),
        ]);
    }
}
