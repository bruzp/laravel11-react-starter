<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Question\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function getQuestions(int $paginate, array $conditions = []): Collection|LengthAwarePaginator
    {
        $query = Question::query();

        $this->getQuestionsQuerySelect($query, $conditions);

        $this->getQuestionsQueryFilters($query, $conditions);

        $this->getQuestionsQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findQuestionById(int $id): ?Question
    {
        return Question::find($id);
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

    public function deleteQuestion(Question $question): void
    {
        $question->delete();
    }

    public function reIndexPriority(int $questionnaire_id): void
    {
        $conditions = [
            'questionnaire_id' => $questionnaire_id,
            'select' => [
                'id',
                'questionnaire_id',
                'priority',
            ]
        ];
        $questions = $this->getQuestions(0, $conditions);
        $priority = 1;

        foreach ($questions as $question) {
            $question->update([
                'priority' => $priority++
            ]);
        }
    }

    private function getQuestionsQuerySelect(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['select'])) {
            $query->select($conditions['select']);
        }
    }

    private function getQuestionsQueryFilters(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['search'])) {
            $query->where(function (Builder $query) use ($conditions) {
                $query->whereLike('question', $conditions['search']);
            });
        }

        if (isset($conditions['questionnaire_id'])) {
            $query->where('questionnaire_id', $conditions['questionnaire_id']);
        }
    }

    private function getQuestionsQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'priority';

        $query->orderBy($order_by, $order);
    }
}
