<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    /**
     * Get all roles with their assigned permissions.
     */
    public function getAllWithPermissions(): Collection;

    /**
     * Get all available permissions in the system.
     */
    public function getAllPermissions(): Collection;

    /**
     * Find a role by id.
     */
    public function find(int $id): ?Role;

    /**
     * Sync a role's permissions (replace with the given list).
     */
    public function updatePermissions(Role $role, array $permissionNames): Role;
}