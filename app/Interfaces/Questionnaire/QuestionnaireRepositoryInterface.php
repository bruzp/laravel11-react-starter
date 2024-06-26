<?php

namespace App\Interfaces\Questionnaire;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface QuestionnaireRepositoryInterface
{
    public function getQuestionnaires(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator;

    public function findQuestionnaire(array $conditions, array $relations = []): ?Questionnaire;

    public function findQuestionnaireById(int $id, array $relations = []): ?Questionnaire;

    public function storeQuestionnaire(array $data): Questionnaire;

    public function updateQuestionnaire(Questionnaire $questionnaire, array $data): void;

    public function deleteQuestionnaire(Questionnaire $questionnaire): void;
}
