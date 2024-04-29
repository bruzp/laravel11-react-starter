<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Interfaces\Answer\AnswerRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'questionnaire_id',
        'user_id',
        'answers',
        'result',
        'questionnaire_data',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding(mixed $value, $field = null)
    {
        $answerRepository = app(AnswerRepositoryInterface::class);

        return empty($field)
            ? $answerRepository->findAnswerById($value)
            : $answerRepository->findAnswer([$field => $value]);
    }
}
