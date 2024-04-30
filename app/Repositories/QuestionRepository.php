<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Repositories\SetRelationsTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Question\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    use SetRelationsTrait;

    public function getQuestions(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator
    {
        $query = Question::query();

        $this->setRelations($query, $relations);

        $this->getQuestionsQuerySelect($query, $conditions);

        $this->getQuestionsQueryFilters($query, $conditions);

        $this->getQuestionsQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findQuestion(array $conditions, array $relations = []): ?Question
    {
        $query = Question::query();

        $this->setRelations($query, $relations);

        $this->getQuestionsQueryFilters($query, $conditions);

        return $query->first();
    }

    public function findQuestionById(int $id, array $relations = []): ?Question
    {
        $query = Question::query();

        $this->setRelations($query, $relations);

        return $query->find($id);
    }

    public function storeQuestion(array $data): Question
    {
        return Question::create($data);
    }

    public function updateQuestion(Question $question, array $data): void
    {
        $question->fill($data);

        $question->save();
    }

    public function updateQuestionsPriority(array $data): void
    {
        $case = "CASE id ";

        foreach ($data as $question) {
            $case .= "WHEN {$question['id']} THEN '{$question['priority']}' ";
        }

        $case .= "END";

        $ids = implode(',', array_column($data, 'id'));

        DB::update("UPDATE questions SET priority = $case WHERE id IN ($ids)");
    }

    public function deleteQuestion(Question $question): void
    {
        $question->delete();
    }

    private function getQuestionsQuerySelect(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['select'])) {
            $query->select($conditions['select']);
        } else {
            $query->select([
                'questions.*',
            ]);
        }
    }

    private function getQuestionsQueryFilters(Builder $query, ?array $conditions): void
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
                        $query->whereLike('question', $conditions['search']);
                    });
                    break;

                default:
                    $query->where($key, $value);
                    break;
            }
        }
    }

    private function getQuestionsQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'ASC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'questions.priority';

        $query->orderBy($order_by, $order);
    }
}
