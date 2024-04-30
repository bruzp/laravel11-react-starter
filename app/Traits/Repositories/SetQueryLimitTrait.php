<?php

namespace App\Traits\Repositories;

use Illuminate\Database\Eloquent\Builder;

trait SetQueryLimitTrait
{
    private function setQueryLimit(Builder $query, ?array $conditions, ?int $paginate): void
    {
        if ($paginate) {
            return;
        }

        if (empty($conditions['limit'])) {
            return;
        }

        $query->limit($conditions['limit']);
    }
}
