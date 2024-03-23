<?php

namespace App\Service;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class IUserService implements UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve users implementation.
     * 
     * @param Request $request
     * @return Collection
     */
    public function getUsers(Request $request): Collection
    {
        return $this->userRepository->get($request);
    }

    /**
     * Retrieve total users implementation.
     * 
     * @return int
     */
    public function countUser(): int
    {
        return $this->userRepository->count();
    }

    /**
     * Retrieve user implementation.
     * 
     * @param string $uuid
     * @return ?User
     */
    public function findUser(string $uuid): ?User
    {
        return $this->userRepository->find($uuid);
    }

    /**
     * Delete user implementation.
     * 
     * @param string $uuid
     * @return void
     */
    public function deleteUser(User $user)
    {
        return $this->userRepository->delete($user);
    }
}