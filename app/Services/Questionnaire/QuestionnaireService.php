<?php

namespace App\Services\Questionnaire;

use Illuminate\Database\Eloquent\Collection;

class QuestionnaireService
{
    /**
     * Check exam and return score by percentage of total.
     */
    public function checkExam(array $answers, Collection $questions): int
    {
        $score = 0;
        $total = $questions->count();

        foreach ($questions as $question) {
            if (
                isset($answers[$question->id]) &&
                $answers[$question->id] == $question->answer
            ) {
                $score++;
            }
        }

        return ($score / $total) * 100;
    }
}
