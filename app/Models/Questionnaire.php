<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Interfaces\Questionnaire\QuestionnaireRepositoryInterface;

class Questionnaire extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'title',
        'description',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)
            ->orderBy('priority');
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding(mixed $value, $field = null)
    {
        $questionnaireRepository = app(QuestionnaireRepositoryInterface::class);

        return empty($field)
            ? $questionnaireRepository->findQuestionnaireById($value)
            : $questionnaireRepository->findQuestionnaire([$field => $value]);
    }
}
