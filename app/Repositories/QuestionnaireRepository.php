<?php

namespace App\Repositories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\Repositories\SetQueryRelationsTrait;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;

class QuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    use SetQueryRelationsTrait;

    public function getQuestionnaires(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator
    {
        $query = Questionnaire::query();

        $this->setQueryRelations($query, $relations);

        $this->getQuestionnairesQuerySelect($query, $conditions);

        $this->getQuestionnairesQueryFilters($query, $conditions);

        $this->getQuestionnairesQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findQuestionnaire(array $conditions, array $relations = []): ?Questionnaire
    {
        $query = Questionnaire::query();

        $this->setQueryRelations($query, $relations);

        $this->getQuestionnairesQueryFilters($query, $conditions);

        return $query->first();
    }

    public function findQuestionnaireById(int $id, array $relations = []): ?Questionnaire
    {
        $query = Questionnaire::query();

        $this->setQueryRelations($query, $relations);

        return $query->find($id);
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
        foreach ($conditions as $key => $value) {
            if (in_array($key, config('define.repository_skip_filters'))) {
                continue;
            }

            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'search':
                    $query->where(function (Builder $query) use ($conditions) {
                        $query->whereLike('title', $conditions['search'])
                            ->orWhereLike('description', $conditions['search']);
                    });
                    break;

                default:
                    $query->where($key, $value);
                    break;
            }
        }
    }

    private function getQuestionnairesQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'questionnaires.updated_at';

        $query->orderBy($order_by, $order);
    }
}
