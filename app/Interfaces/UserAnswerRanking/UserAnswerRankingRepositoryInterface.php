<?php

namespace App\Interfaces\UserAnswerRanking;

use App\Models\UserAnswerRanking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserAnswerRankingRepositoryInterface
{
    public function getUserAnswerRankings(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator;

    public function findUserAnswerRanking(array $conditions, array $relations = []): ?UserAnswerRanking;

    public function findUserAnswerRankingByUserId(int $user_id, array $relations = []): ?UserAnswerRanking;
}
