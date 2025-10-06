<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $fields = ['id', 'name'];
        $roles = $this->roleService->getAll($fields);
        return view('pages.role.index', compact('roles'));
    }

    public function create()
    {
        return view('pages.role.create');
    }

    public function edit(int $id)
    {
        $fields = ['id', 'name'];
        $role = $this->roleService->getById($id, $fields);
        return view('pages.role.edit', compact('role'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);
        $role = $this->roleService->create($validatedData);
        return back()->with('success', 'Role created successfully');
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $role = $this->roleService->update($id, $validatedData);
        return back()->with('success', 'Role updated successfully');
    }

    public function destroy(int $id)
    {
        $this->roleService->delete($id);
        return back()->with('success', 'Role deleted successfully');
    }
}
