<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getUsers(int $paginate = 0, ...$conditions): Collection
    {
        $query = User::query();

        // Do some more filtering when conditions are set.

        return $paginate
            ? $query->paginate($paginate)
            : $query->get();
    }

    public function findUserById(int $id): ?User
    {
        return User::find($id);
    }


    public function storeUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(User $user, array $data): void
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
