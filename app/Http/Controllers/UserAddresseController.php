<?php

namespace App\Http\Controllers;

use App\Models\UserAddresse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserAddresseRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
class UserAddresseController extends Controller
{
    public function index(Request $request): mixed
    {
        $userAddresses = UserAddresse::paginate();
        return Inertia::render('Customer/UserAddresses/Index', ['user_addresses' => $userAddresses, 'i' => ($request->input('page', 1) - 1) * $userAddresses->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/UserAddresses/Create', ['user_addresses' => new UserAddresse() ]);
    }
    public function store(UserAddresseRequest $request): RedirectResponse
    {
        UserAddresse::create($request->validated());
        return Redirect::route('addresses_users.index')->with('success', '¡La dirección de envío ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $userAddresses = UserAddresse::findOrFail($id);
        return Inertia::render('Customer/UserAddresses/Show', ['user_addresses' => $userAddresses ]);
    }
    public function edit($id): mixed
    {
        $userAddresses = UserAddresse::findOrFail($id);
        return Inertia::render('Customer/UserAddresses/Edit', ['user_addresses' => $userAddresses ]);
    }
    public function update(UserAddresseRequest $request, UserAddresse $userAddresses): RedirectResponse
    {
        $userAddresses->update($request->validated());
        return Redirect::route('addresses_users.index')->with('success', '¡La dirección de envío ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        UserAddresse::findOrFail($id)->delete();
        return Redirect::route('addresses_users.index')->with('success', '¡La dirección de envío ha sido eliminada correctamente!');
    }
}