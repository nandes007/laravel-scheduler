<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserService
{
    /**
     * Retrieve users interface.
     * 
     * @param Request $request
     * @return Collection
     */
    public function getUsers(Request $request): Collection;

    /**
     * Retrieve total users interface.
     * 
     * @return int
     */
    public function countUser(): int;

    /**
     * Retrieve user interface.
     * 
     * @param string $uuid
     * @return ?User
     */
    public function findUser(string $uuid): ?User;

    /**
     * Delete user interface.
     * 
     * @param string $uuid
     * @return void
     */
    public function deleteUser(User $user);
}