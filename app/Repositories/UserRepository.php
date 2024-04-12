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

    /**
     * Get user by id.
     *
     * @param integer $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Add user info to users table.
     *
     * @param array $data
     * @return User
     */
    public function storeUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update users data.
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    public function updateUser(User $user, array $data): void
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    /**
     * Delete user.
     *
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
