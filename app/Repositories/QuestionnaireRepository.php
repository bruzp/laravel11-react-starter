<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;

class QuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    public function getQuestionnaires(int $paginate, array $conditions = []): Collection|LengthAwarePaginator
    {
        $query = Questionnaire::query();

        $this->getUsersQueryFilters($query, $conditions);

        $this->getUsersQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findQuestionnaireById(int $id): ?Questionnaire
    {
        return Questionnaire::find($id);
    }

    public function storeQuestionnaire(array $data): Questionnaire
    {
        return Questionnaire::create($data);
    }

    public function updateQuestionnaire(Questionnaire $questionnaire, array $data): void
    {
        $questionnaire->fill($data);

        $questionnaire->save();
    }

    public function deleteQuestionnaire(Questionnaire $questionnaire): void
    {
        $questionnaire->delete();
    }

    private function getUsersQueryFilters(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['search'])) {
            $query->where(function (Builder $query) use ($conditions) {
                $query->whereLike('title', $conditions['search'])
                    ->orWhereLike('description', $conditions['search']);
            });
        }

        if (isset($conditions['admin_id'])) {
            $query->where('admin_id', $conditions['admin_id']);
        }
    }

    private function getUsersQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'updated_at';

        $query->orderBy($order_by, $order);
    }
}
