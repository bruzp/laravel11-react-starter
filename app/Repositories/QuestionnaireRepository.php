<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;

class QuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    public function getQuestionnaires(array $conditions = [], int $paginate = 0): Collection|LengthAwarePaginator
    {
        $query = Questionnaire::query();

        $this->getQuestionnairesQuerySelect($query, $conditions);

        $this->getQuestionnairesQueryFilters($query, $conditions);

        $this->getQuestionnairesQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findQuestionnaire(array $conditions): ?Questionnaire
    {
        $query = Questionnaire::query();

        $this->getQuestionnairesQueryFilters($query, $conditions);

        return $query->first();
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
        $questionnaire->questions()->update([
            'deleted_at' => now()
        ]);

        $questionnaire->delete();
    }

    private function getQuestionnairesQuerySelect(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['select'])) {
            $query->select($conditions['select']);
        } else {
            $query->select([
                'questionnaires.*',
            ]);
        }
    }

    private function getQuestionnairesQueryFilters(Builder $query, ?array $conditions): void
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

    private function getQuestionnairesQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'questionnaires.updated_at';

        $query->orderBy($order_by, $order);
    }
}
