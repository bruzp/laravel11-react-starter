<?php

namespace App\Models;

use App\Helpers\Common\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Interfaces\UserAnswerRanking\UserAnswerRankingRepositoryInterface;

class UserAnswerRanking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends = ['rank_text'];

    protected function rankText(): Attribute
    {
        return Attribute::make(
            get: fn() => Helper::ordinal($this->rank_no),
        );
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
        $userRankingRepository = app(UserAnswerRankingRepositoryInterface::class);

        return empty($field)
            ? $userRankingRepository->findUserAnswerRankingByUserId($value)
            : $userRankingRepository->findUserAnswerRankingBy([$field => $value]);
    }
}
