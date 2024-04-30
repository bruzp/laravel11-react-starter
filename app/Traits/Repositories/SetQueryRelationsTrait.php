<?php

namespace App\Traits\Repositories;

use Illuminate\Database\Eloquent\Builder;

trait SetQueryRelationsTrait
{
    private function setQueryRelations(Builder $query, ?array $relations): void
    {
        if (empty($relations)) {
            return;
        }

        $query->with($relations);
    }
}
