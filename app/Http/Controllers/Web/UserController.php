<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;
    private RoleService $roleService;
    private UserRoleService $userRoleService;

    public function __construct(
        UserService $userService,
        RoleService $roleService,
        UserRoleService $userRoleService,
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->userRoleService = $userRoleService;
    }

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'nullable|string|max:15',
        ]);

        $user = $this->userService->create($validatedData);
        return back()->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'nullable|string|max:15',
        ]);

        $user = $this->userService->update($id, $validatedData);
        return back()->with('success', 'User updated successfully.');
    }

    public function assignRole(Request $request)
    {
        $users = $this->userService->getAll(['id', 'name']);
        $roles = $this->roleService->getAll(['id', 'name']);
        return view('pages.user.user-role.assign-role', compact('users', 'roles'));
    }

    public function assignRoleStore(Request $request)
    {
        $validatedData = $request->validate([
            'user' => 'required|exists:users,id',
            'role' => 'required|exists:roles,id',
        ]);

        $user = $this->userService->getById($validatedData['user'], ['*']);
        if ($user->roles->contains('id', $validatedData['role'])) {
            return back()->withErrors(['role' => 'User already has this role assigned.']);
        }

        $user = $this->userRoleService->assignRole(
            $validatedData['user'],
            $validatedData['role'],
        );

        return back()->with('success', 'Role assigned successfully.');
    }
}
