<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\User\AnswerResource;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use App\Http\Requests\User\Answer\SearchAnswersRequest;

class AnswerController extends Controller
{
    public function __construct(private AnswerRepositoryInterface $answerRepository)
    {
    }

    public function index(SearchAnswersRequest $request): InertiaResponse
    {
        return Inertia::render('User/Answer/Index', [
            'answers' => AnswerResource::collection($this->answerRepository->getAnswers($request->prepareForSearch(), 30)),
            'query_params' => $request->validated() ?: null,
        ]);
    }
}
