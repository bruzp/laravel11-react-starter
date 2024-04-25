<?php

namespace App\Repositories;

use App\Models\UserAnswerRanking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\UserAnswerRanking\UserAnswerRankingRepositoryInterface;

class UserAnswerRankingRepository implements UserAnswerRankingRepositoryInterface
{
    public function getUserAnswerRankings(int $paginate = 0, array $conditions = []): Collection|LengthAwarePaginator
    {
        $query = UserAnswerRanking::query();

        $this->getUserAnswerRankingsQuerySelect($query, $conditions);

        $this->getUserAnswerRankingsQueryFilters($query, $conditions);

        $this->getUserAnswerRankingsQueryOrderBy($query, $conditions);

        if (!$paginate) {
            $this->getUserAnswerRankingsQueryLimit($query, $conditions);
        }

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findUserAnswerRankingByUserId(int $user_id): ?UserAnswerRanking
    {
        return UserAnswerRanking::query()
            ->where('user_id', $user_id)
            ->first();
    }

    private function getUserAnswerRankingsQueryFilters(Builder $query, ?array $conditions): void
    {

        if (isset($conditions['user_id'])) {
            $query->where('user_id', $conditions['user_id']);
        }
    }

    private function getUserAnswerRankingsQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'ASC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'rank_no';

        $query->orderBy($order_by, $order);
    }

    private function getUserAnswerRankingsQueryLimit(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['limit'])) {
            $query->limit($conditions['limit']);
        }
    }

    private function getUserAnswerRankingsQuerySelect(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['select'])) {
            $query->select($conditions['select']);
        } else {
            $query->select([
                'rank_no',
                'user_id',
                'max_result',
            ]);
        }
    }
}
