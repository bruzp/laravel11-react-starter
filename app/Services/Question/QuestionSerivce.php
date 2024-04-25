<?php

namespace App\Services\Question;

use App\Models\Question;

class QuestionSerivce
{
    public function prepareDataForUpdatingPriority(int $questionnaire_id): array
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

    public function getMaxPriority(int $questionnaire_id): int
    {
        $max_priority = Question::where('questionnaire_id', $questionnaire_id)->max('priority');

        return $max_priority ? $max_priority + 1 : 1;
    }
}
