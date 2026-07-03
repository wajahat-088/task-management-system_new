<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Get paginated users with their current role.
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a user by id.
     */
    public function find(int $id): ?User;

    /**
     * Change a user's role (replaces any existing role).
     */
    public function updateRole(User $user, string $roleName): User;
}