<?php

namespace App\Interfaces\Answer;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AnswerRepositoryInterface
{
    public function getAnswers(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator;

    public function findAnswer(array $conditions, array $relations = []): ?Answer;

    public function findAnswerById(int $id, array $relations = []): ?Answer;

    public function storeAnswer(array $data): Answer;

    public function updateAnswer(Answer $answer, array $data): void;

    public function deleteAnswer(Answer $answer): void;
}
