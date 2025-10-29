<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
class UserController extends Controller
{
    public function index(Request $request): mixed
    {
        $users = User::with("roles")->paginate();
        return Inertia::render('Auth/User/Index', ['users' => $users, 'i' => ($request->input('page', 1) - 1) * $users->perPage()]);
    }
    public function create(): mixed
    {
        $roles = Role::pluck("name")->all();
        $user = new User();
        return Inertia::render('Auth/User/Create', ['user' => $user, 'roles' => $roles]);
    }
    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (isset($validated['password']) && filled($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user = User::create($validated);
        $user->syncRoles($validated['roles']);

        return Redirect::route('users.index')->with('success', '¡El usuario ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $user = User::findOrFail($id);
        $userRoles = $user->roles()->pluck("name")->all();
        return Inertia::render('Auth/User/Show', ['user' => $user, 'userRoles' => $userRoles]);
    }
    public function edit($id): mixed
    {
        $user = User::findOrFail($id);
        $userRoles = $user->roles()->pluck("name")->all();
        return Inertia::render('Auth/User/Edit', ['user' => $user, 'userRoles' => $userRoles]);
    }
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (isset($validated['password']) && filled($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        $user->syncRoles($validated['roles']);

        return Redirect::route('users.index')->with('success', '¡El usuario ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        User::findOrFail($id)->delete();
        return Redirect::route('users.index')->with('success', '¡El usuario ha sido eliminado correctamente!');
    }
}