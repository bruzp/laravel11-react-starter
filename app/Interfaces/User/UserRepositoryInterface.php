<?php

namespace App\Interfaces\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getUsers(int $paginate, array $conditions = []): Collection|LengthAwarePaginator;

    public function findUserById(int $id): ?User;

    public function storeUser(array $data): User;

    public function updateUser(User $user, array $data): void;

    public function deleteUser(User $user): void;
}
