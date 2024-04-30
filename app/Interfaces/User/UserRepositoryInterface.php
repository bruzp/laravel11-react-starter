<?php

namespace App\Interfaces\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getUsers(array $conditions = [], int $paginate = 0, array $relations = []): Collection|LengthAwarePaginator;

    public function findUser(array $conditions, array $relations = []): ?User;

    public function findUserById(int $id, array $relations = []): ?User;

    public function storeUser(array $data): User;

    public function updateUser(User $user, array $data): void;

    public function deleteUser(User $user): void;
}
