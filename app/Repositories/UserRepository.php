<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getUsers(array $conditions = [], int $paginate = 0): Collection|LengthAwarePaginator
    {
        $query = User::query();

        $this->getUsersQuerySelect($query, $conditions);

        $this->getUsersQueryFilters($query, $conditions);

        $this->getUsersQueryOrderBy($query, $conditions);

        return $paginate
            ? $query->paginate($paginate)->onEachSide(1)
            : $query->get();
    }

    public function findUser(array $conditions): ?User
    {
        $query = User::query();

        $this->getUsersQueryFilters($query, $conditions);

        return $query->first();
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

    private function getUsersQuerySelect(Builder $query, ?array $conditions): void
    {
        if (isset($conditions['select'])) {
            $query->select($conditions['select']);
        } else {
            $query->select([
                'users.*',
            ]);
        }
    }

    private function getUsersQueryFilters(Builder $query, ?array $conditions): void
    {
        foreach ($conditions as $key => $value) {
            if (in_array($key, config('define.repository_skip_filters'))) {
                continue;
            }

            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'search':
                    $query->where(function (Builder $query) use ($conditions) {
                        $query->whereLike('name', $conditions['search'])
                            ->orWhereLike('email', $conditions['search']);
                    });
                    break;

                default:
                    $query->where($key, $value);
                    break;
            }
        }
    }

    private function getUsersQueryOrderBy(Builder $query, ?array $conditions): void
    {
        $order = isset($conditions['order']) ? $conditions['order'] : 'DESC';
        $order_by = isset($conditions['order_by']) ? $conditions['order_by'] : 'updated_at';

        $query->orderBy($order_by, $order);
    }
}
