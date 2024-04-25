<?php

namespace App\Interfaces\Question;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface QuestionRepositoryInterface
{
    public function getQuestions(int $paginate, array $conditions = []): Collection|LengthAwarePaginator;

    public function findQuestionById(int $id): ?Question;

    public function storeQuestion(array $data): Question;

    public function updateQuestion(Question $question, array $data): void;

    public function updateQuestionsPriority(array $data): void;

    public function deleteQuestion(Question $question): void;
}
