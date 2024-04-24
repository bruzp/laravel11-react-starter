<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Questionnaire;
use App\Services\Answer\AnswerService;
use Illuminate\Auth\Access\Response;

class QuestionnairePolicy
{
    public function __construct(private AnswerService $answerService)
    {
    }

    public function takeExam(User $user, Questionnaire $questionnaire): Response
    {
        $is_answered = $this->answerService->isAnswered($user->id, $questionnaire->id);

        return !$is_answered
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
