<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\AnswerResource;
use Inertia\Response as InertiaResponse;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use App\Http\Requests\Admin\Answer\SearchAnswersRequest;

class AnswerController extends Controller
{
    public function __construct(private AnswerRepositoryInterface $answerRepository)
    {
    }

    public function index(SearchAnswersRequest $request): InertiaResponse
    {
        return Inertia::render('Admin/Answer/Index', [
            'answers' => AnswerResource::collection($this->answerRepository->getAnswers(30, $request->validated())),
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