<?php

namespace App\Repositories;

use App\Models\UserAnswerRanking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Repositories\SetRelationsTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\UserAnswerRanking\UserAnswerRankingRepositoryInterface;

class UserAnswerRankingRepository implements UserAnswerRankingRepositoryInterface
{
    use SetRelationsTrait;

    public function getUserAnswerRankings(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator
    {
        $query = UserAnswerRanking::query();

        $this->setRelations($query, $relations);

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

    public function findUserAnswerRanking(array $conditions, array $relations = []): ?UserAnswerRanking
    {
        $query = UserAnswerRanking::query();

        $this->setRelations($query, $relations);

        $this->getUserAnswerRankingsQueryFilters($query, $conditions);

        return $query->first();
    }

    public function findUserAnswerRankingByUserId(int $user_id, array $relations = []): ?UserAnswerRanking
    {
        $query = UserAnswerRanking::query();

        $this->setRelations($query, $relations);

        return $query
            ->where('user_id', $user_id)
            ->first();
    }

    private function getUserAnswerRankingsQueryFilters(Builder $query, ?array $conditions): void
    {
        foreach ($conditions as $key => $value) {
            if (in_array($key, config('define.repository_skip_filters'))) {
                continue;
            }

            if (empty($value)) {
                continue;
            }

            switch ($key) {
                default:
                    $query->where($key, $value);
                    break;
            }
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
