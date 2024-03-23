<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class IUserRepository implements UserRepository
{
    /**
     * Retrieve users implementation.
     * 
     * @param Request $request
     * @return Collection
     */
    public function get(Request $request): LengthAwarePaginator
    {
        $user = User::select([
            'uuid',
            'name',
            'age',
            'gender',
            'created_at'
        ])->paginate(10);

        return $user;
    }

    /**
     * Retrieve total users implementation.
     * 
     * @return int
     */
    public function count(): int
    {
        return User::select(['id'])->count();
    }

    /**
     * Retrieve user implementation.
     * 
     * @param string $uuid
     * @return ?User
     */
    public function find(string $uuid): ?User
    {
        return User::select([
            'uuid',
            'name',
            'age',
            'gender',
            'created_at'
        ])->where('uuid', $uuid)->first();
    }

    /**
     * Delete user implementation.
     * 
     * @param string $uuid
     * @return void
     */
    public function delete(User $user)
    {
        $user->delete();
    }
}