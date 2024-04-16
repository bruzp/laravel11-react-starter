<?php

namespace App\Interfaces\Questionnaire;

use App\Models\Questionnaire;

interface QuestionnaireRepositoryInterface
{
    public function getQuestionnaires(int $paginate, array $conditions = []);

    public function findQuestionnaireById(int $id);

    public function storeQuestionnaire(array $data);

    public function updateQuestionnaire(Questionnaire $questionnaire, array $data);

    public function deleteQuestionnaire(Questionnaire $questionnaire);
}
