<?php

namespace App\Interfaces\UserAnswerRanking;

interface UserAnswerRankingRepositoryInterface
{
    public function getUserAnswerRankings(int $paginate, array $conditions = []);

    public function findUserAnswerRankingByUserId(int $user_id);
}
