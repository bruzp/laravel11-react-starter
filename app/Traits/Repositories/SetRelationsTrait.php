<?php

namespace App\Traits\Repositories;

use Illuminate\Database\Eloquent\Builder;

trait SetRelationsTrait
{
    private function setRelations(Builder $query, ?array $relations): void
    {
        if (empty($relations)) {
            return;
        }

        $query->with($relations);
    }
}
