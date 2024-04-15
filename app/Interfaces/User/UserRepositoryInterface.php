<?php

namespace App\Interfaces\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getUsers(int $paginate, array $conditions = []);

    public function findUserById(int $id);

    public function storeUser(array $data);

    public function updateUser(User $user, array $data);

    public function deleteUser(User $user);
}
