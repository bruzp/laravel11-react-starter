<?php

namespace App\Interfaces\Answer;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AnswerRepositoryInterface
{
    public function getAnswers(int $paginate, array $conditions = []): Collection|LengthAwarePaginator;

    public function findAnswer(array $conditions): ?Answer;

    public function findAnswerById(int $id): ?Answer;

    public function storeAnswer(array $data): Answer;

    public function updateAnswer(Answer $answer, array $data): void;

    public function deleteAnswer(Answer $answer): void;
}
