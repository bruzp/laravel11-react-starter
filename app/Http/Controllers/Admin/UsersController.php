<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use App\Http\Resources\Admin\UserResource;
use App\Interfaces\User\UserRepositoryInterface;
use App\Http\Requests\Admin\Users\StoreUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Http\Requests\Admin\Users\SearchUsersRequest;

class UsersController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function index(SearchUsersRequest $request): InertiaResponse
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection($this->userRepository->getUsers(30, $request->validated())),
            'status' => session('status'),
            'query_params' => $request->validated() ?: null,
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->userRepository->storeUser($request->validated());

        return redirect()
            ->route('admin.users.edit', $user->id)
            ->with('status', 'Success!');
    }

    public function edit(User $user): InertiaResponse
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
            'status' => session('status'),
        ]);
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (!$request->filled('password')) {
            unset($data['password']);
        }

        $this->userRepository->updateUser($user, $data);

        return redirect()
            ->route('admin.users.edit', $user->id, 303)
            ->with('status', 'Success!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userRepository->deleteUser($user);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Success!');
    }
}
