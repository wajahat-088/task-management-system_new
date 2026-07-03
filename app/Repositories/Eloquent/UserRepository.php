<?php

namespace App\Repositories\Eloquent;

use App\Models\ActivityLog;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $model)
    {
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('roles')->latest()->paginate($perPage);
    }

    public function find(int $id): ?User
    {
        return $this->model->with('roles')->find($id);
    }

    public function updateRole(User $user, string $roleName): User
    {
        $oldRole = $user->getRoleNames()->first() ?? 'none';

        // syncRoles will replace the user's current roles with the new role.
        $user->syncRoles($roleName);

        ActivityLog::record(
            $user,
            'role_changed',
            "changed role of user '{$user->name}' from {$oldRole} to {$roleName}"
        );

        return $user->load('roles');
    }
}