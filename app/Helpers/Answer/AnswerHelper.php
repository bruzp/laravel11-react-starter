<?php

namespace App\Helpers\Answer;

class AnswerHelper
{
    public static function examScoreMessage(int $score_percentage): string
    {
        if ($score_percentage < 80) {
            return 'You scored ' . $score_percentage . '% on the exam. Every challenge is an opportunity to learn and grow. You’ve got this!';
        } elseif ($score_percentage >= 80 && $score_percentage < 90) {
            return 'Great work! You scored ' . $score_percentage . '% on the exam. Your effort is paying off. Let’s aim even higher next time!';
        } elseif ($score_percentage >= 90 && $score_percentage < 100) {
            return 'Outstanding performance! You scored ' . $score_percentage . '%. You’re excelling, keep up the fantastic work!';
        }

        return 'Perfection achieved! You scored 100%. Congratulations on this exceptional accomplishment!';
    }

}
