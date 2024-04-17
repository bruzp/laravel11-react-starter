<?php

namespace App\Interfaces\Question;

use App\Models\Question;

interface QuestionRepositoryInterface
{
    public function getQuestions(int $paginate, array $conditions = []);

    public function findQuestionById(int $id);

    public function storeQuestion(array $data);

    public function updateQuestion(Question $question, array $data);

    public function deleteQuestion(Question $question);
}
