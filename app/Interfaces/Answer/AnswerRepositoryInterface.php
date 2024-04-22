<?php

namespace App\Interfaces\Answer;

use App\Models\Answer;

interface AnswerRepositoryInterface
{
    public function getAnswers(int $paginate, array $conditions = []);

    public function findAnswerById(int $id);

    public function storeAnswer(array $data);

    public function updateAnswer(Answer $answer, array $data);

    public function deleteAnswer(Answer $answer);
}
