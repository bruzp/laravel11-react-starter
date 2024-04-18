<?php

namespace App\Helpers\Question;

use App\Models\Question;

class QuestionHelper
{
    public static function prepareDataForUpdatingPriority(int $questionnaire_id): array
    {
        $questions = Question::query()
            ->select('id')
            ->where('questionnaire_id', $questionnaire_id)
            ->orderBy('priority')
            ->get();

        $priority = 1;
        $data = [];

        foreach ($questions as $question) {
            $data[] = [
                'id' => $question->id,
                'priority' => $priority++
            ];
        }

        return $data;
    }
}
