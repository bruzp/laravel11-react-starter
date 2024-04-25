<?php

namespace App\Interfaces\UserAnswerRanking;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserAnswerRankingRepositoryInterface
{
    public function getUserAnswerRankings(int $paginate, array $conditions = []): Collection|LengthAwarePaginator;

    public function findUserAnswerRankingByUserId(int $user_id): ?UserAnswerRanking;
}
