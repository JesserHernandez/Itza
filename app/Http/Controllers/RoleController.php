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
        return Inertia::render( 'Auth/Role/Index', ['roles' => $roles, 'i' => ($request->input('page', 1) - 1) * $roles->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Auth/Role/Create', ['role' => new Role(), "permissions" => Permission::pluck("name")->all()]);
    }
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());
        $role->syncPermissions($request['permissions']);
        return Redirect::route('roles.index')->with('success', '¡El rol ha sido guardado correctamente!');
    }
    public function show(string $id): mixed
    {
        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions()->pluck("name")->all();
        return Inertia::render('Auth/Role/Show', ['role' => $role, "rolePermissions" => $rolePermissions]);
    }
    public function edit(string $id): mixed
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::pluck("name")->all();
        $rolePermissions = $role->permissions()->pluck("name")->all();
        return Inertia::render('Auth/Role/Edit', ['role' => $role, "permissions" => $permissions, "rolePermissions" => $rolePermissions]);
    }
    public function update(RoleRequest $request, string $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->update($request->validated());
        $role->syncPermissions($request['permissions']);
        return Redirect::route('roles.index')->with('success', '¡El rol ha sido actualizado correctamente!');
    }
    public function destroy(string $id): RedirectResponse
    {
        Role::findOrFail($id)->delete();
        return Redirect::route('roles.index')->with('success', '¡El rol ha sido eliminado correctamente!');
    }
}