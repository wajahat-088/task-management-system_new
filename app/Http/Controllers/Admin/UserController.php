<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:manage-users'),
        ];
    }

    /**
     * List all users with their current role.
     */
    public function index()
    {
        $users = $this->userRepository->getPaginated();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Change a user's role.
     */
     public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = $this->userRepository->updateRole($user, $validated['role']);

        return response()->json([
            'success' => true,
            'message' => "Role for '{$user->name}' updated successfully!",
            'role'    => $user->getRoleNames()->first(),
        ]);
    }
}