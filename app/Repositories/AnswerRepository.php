<?php

namespace App\Repositories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Answer\AnswerRepositoryInterface;

class AnswerRepository implements AnswerRepositoryInterface
{
    public function getAnswers(int $paginate = 0, array $conditions = []): Collection|LengthAwarePaginator
    {
        $query = Answer::query()
            ->select([
                'answers.*',
                'questionnaires.title',
                'users.name',
                'users.email',
            ])
            ->join('questionnaires', 'questionnaires.id', '=', 'answers.questionnaire_id')
            ->join('users', 'users.id', '=', 'answers.user_id');

        $this->getAnswersQueryFilters($query, $conditions);

        $this->getAnswersQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findAnswerById(int $id): ?Answer
    {
        return Answer::find($id);
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

    private function getAnswersQueryFilters(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['search'])) {
            $query->where(function (Builder $query) use ($conditions) {
                $query->whereLike('name', $conditions['search'])
                    ->orWhereLike('email', $conditions['search'])
                    ->orWhereLike('title', $conditions['search'])
                    ->orWhereLike('description', $conditions['search']);
            });
        }
    }

    private function getAnswersQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'updated_at';

        $query->orderBy($order_by, $order);
    }
}
