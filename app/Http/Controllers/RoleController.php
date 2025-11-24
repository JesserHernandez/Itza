<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function index(Request $request): mixed
    {
        $roles = Role::with("permissions")->paginate();
        return Inertia::render( 'Administrator/Role/Index', ['roles' => $roles, 'i' => ($request->input('page', 1) - 1) * $roles->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Administrator/Role/Create', ['role' => new Role(), "permissions" => Permission::pluck("name")->all()]);
    }
    public function store(RoleRequest $request): RedirectResponse
    {
        // $role = Role::create($request->validated());
        // $role->syncPermissions($request['permissions']);
        return Redirect::route('roles.index')->with('success', '¡No se puede crear roles!');
    }
    public function show(string $id): mixed
    {
        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions()->pluck("name")->all();
        return Inertia::render('Administrator/Role/Show', ['role' => $role, "rolePermissions" => $rolePermissions]);
    }
    public function edit(string $id): mixed
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::pluck("name")->all();
        $rolePermissions = $role->permissions()->pluck("name")->all();
        return Inertia::render('Administrator/Role/Edit', ['role' => $role, "permissions" => $permissions, "rolePermissions" => $rolePermissions]);
    }
    public function update(RoleRequest $request, string $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        // $role->update($request->validated());
        $role->syncPermissions($request['permissions']);
        return Redirect::route('roles.index')->with('success', '¡Los permisos del rol han sido actualizados correctamente!');
    }
    public function destroy(string $id): RedirectResponse
    {
        // Role::findOrFail($id)->delete();
        return Redirect::route('roles.index')->with('success', '¡No se pueden eliminar los roles!');
    }
}