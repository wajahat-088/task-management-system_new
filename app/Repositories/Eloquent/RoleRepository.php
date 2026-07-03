<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(protected Role $model)
    {
    }

    public function getAllWithPermissions(): Collection
    {
        return $this->model->with('permissions')->get();
    }

    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    public function find(int $id): ?Role
    {
        return $this->model->with('permissions')->find($id);
    }

    public function updatePermissions(Role $role, array $permissionNames): Role
    {
        // syncPermissions will replace the role's current permissions with the new list.
        $role->syncPermissions($permissionNames);

        return $role->load('permissions');
    }
}