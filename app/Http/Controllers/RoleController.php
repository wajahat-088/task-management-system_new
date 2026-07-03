<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public function __construct(protected RoleRepositoryInterface $roleRepository)
    {
    }

    public static function middleware(): array
    {
        // Sirf manage-roles permission wale hi is controller ko access kar sakte hain
        return [
            new Middleware('can:manage-roles'),
        ];
    }

    /**
     * List all roles with their current permissions.
     */
    public function index()
    {
        $roles = $this->roleRepository->getAllWithPermissions();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form to edit a role's permissions.
     */
    public function edit(Role $role)
    {
        $allPermissions = $this->roleRepository->getAllPermissions();
        $role->load('permissions');

        return view('roles.edit', compact('role', 'allPermissions'));
    }

    /**
     * Update a role's permissions.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions'   => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $this->roleRepository->updatePermissions($role, $validated['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Permissions for '{$role->name}' updated successfully!");
    }
}