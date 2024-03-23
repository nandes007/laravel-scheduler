<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserRepository
{
    /**
     * Retrieve users interface.
     * 
     * @param Request $request
     * @return Collection
     */
    public function get(Request $request): Collection;

    /**
     * Retrieve total users interface.
     * 
     * @return int
     */
    public function count(): int;

    /**
     * Retrieve user interface.
     * 
     * @param string $uuid
     * @return ?User
     */
    public function find(string $uuid): ?User;

    /**
     * Delete user interface.
     * 
     * @param string $uuid
     * @return void
     */
    public function delete(User $user);
}