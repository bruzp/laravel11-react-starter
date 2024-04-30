<?php

namespace App\Repositories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Repositories\SetRelationsTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Answer\AnswerRepositoryInterface;

class AnswerRepository implements AnswerRepositoryInterface
{
    use SetRelationsTrait;

    public function getAnswers(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator
    {
        $query = Answer::query()
            ->join('questionnaires', 'questionnaires.id', '=', 'answers.questionnaire_id')
            ->join('users', 'users.id', '=', 'answers.user_id');

        $this->setRelations($query, $relations);

        $this->getAnswersQuerySelect($query, $conditions);

        $this->getAnswersQueryFilters($query, $conditions);

        $this->getAnswersQueryOrderBy($query, $conditions);

        if (!$paginate) {
            $this->getAnswersQueryLimit($query, $conditions);
        }

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findAnswer(array $conditions, array $relations = []): ?Answer
    {
        $query = Answer::query();

        $this->setRelations($query, $relations);

        $this->getAnswersQueryFilters($query, $conditions);

        return $query->first();
    }

    public function findAnswerById(int $id, array $relations = []): ?Answer
    {
        $query = Answer::query();

        $this->setRelations($query, $relations);

        return $query->find($id);
    }

    public function storeAnswer(array $data): Answer
    {
        return Answer::create($data);
    }

    public function updateAnswer(Answer $answer, array $data): void
    {
        $answer->fill($data);

        $answer->save();
    }

    public function deleteAnswer(Answer $answer): void
    {
        $answer->delete();
    }

    private function getAnswersQuerySelect(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['select'])) {
            $query->select($conditions['select']);
        } else {
            $query->select([
                'answers.*',
                'questionnaires.title',
                'users.name',
                'users.email',
            ]);
        }
    }

    private function getAnswersQueryFilters(Builder $query, ?array $conditions): void
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
                        $query->whereLike('name', $conditions['search'])
                            ->orWhereLike('email', $conditions['search'])
                            ->orWhereLike('title', $conditions['search'])
                            ->orWhereLike('description', $conditions['search']);
                    });
                    break;

                case 'questionnaire_ids':
                    $query->whereIntegerInRaw('questionnaire_id', $conditions['questionnaire_ids']);
                    break;

                case 'distinct':
                    $query->distinct();
                    break;

                default:
                    $query->where($key, $value);
                    break;
            }
        }
    }

    private function getAnswersQueryOrderBy(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['no_order_by'])) {
            return;
        }

        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'answers.updated_at';

        $query->orderBy($order_by, $order);
    }

    private function getAnswersQueryLimit(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['limit'])) {
            $query->limit($conditions['limit']);
        }
    }
}
