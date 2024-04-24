<?php

namespace App\Services\Answer;

use App\Interfaces\Answer\AnswerRepositoryInterface;

class AnswerService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private AnswerRepositoryInterface $answerRepository)
    {
    }

    public function getUserAnswers(array $questionnaire_ids, int $user_id): array
    {
        return $this->answerRepository->getAnswers(0, [
            'questionnaire_ids' => $questionnaire_ids,
            'user_id' => $user_id,
            'select' => [
                'answers.questionnaire_id',
            ],
            'distinct' => true,
            'no_order_by' => true,
        ])
            ->pluck('questionnaire_id')
            ->all();
    }

    public function isAnswered(int $user_id, int $questionnaire_id): bool
    {
        return (bool) $this->answerRepository->findAnswer([
            'user_id' => $user_id,
            'questionnaire_id' => $questionnaire_id,
        ]);
    }
}
