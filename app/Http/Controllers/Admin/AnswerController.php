<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\Admin\AnswerResource;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use App\Http\Requests\Admin\Answer\SearchAnswersRequest;

class AnswerController extends Controller
{
    public function __construct(private AnswerRepositoryInterface $answerRepository)
    {
    }

    public function index(SearchAnswersRequest $request): InertiaResponse
    {
        $answers = $this->answerRepository->getAnswers($request->validated(), 30);
        $answer_resources = AnswerResource::collection($answers);

        return Inertia::render('Admin/Answer/Index', [
            'answers' => $answer_resources,
            'status' => session('status'),
            'query_params' => $request->validated() ?: null,
        ]);
    }

    public function destroy(Answer $answer): RedirectResponse
    {
        $this->answerRepository->deleteAnswer($answer);

        return redirect()
            ->route('admin.answers.index')
            ->with('status', 'Success!');
    }
}
