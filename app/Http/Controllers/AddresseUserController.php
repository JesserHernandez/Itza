<?php

namespace App\Http\Controllers;

use App\Models\AddresseUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AddresseUserRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
class AddresseUserController extends Controller
{
    public function index(Request $request): mixed
    {
        $addressesUsers = AddresseUser::paginate();
        return Inertia::render('Customer/AddressesUser/Index', ['addressesUsers' => $addressesUsers, 'i' => ($request->input('page', 1) - 1) * $addressesUsers->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/AddressesUser/Create', ['addressesUser' => new AddresseUser() ]);
    }
    public function store(AddresseUserRequest $request): RedirectResponse
    {
        AddresseUser::create($request->validated());
        return Redirect::route('addresses_users.index')->with('success', '¡La dirección de envío ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $addressesUser = AddresseUser::findOrFail($id);
        return Inertia::render('Customer/AddressesUsers/Show', ['addressesUser' => $addressesUser ]);
    }
    public function edit($id): mixed
    {
        $addressesUser = AddresseUser::findOrFail($id);
        return Inertia::render('Customer/AddressesUsers/Edit', ['addressesUser' => $addressesUser ]);
    }
    public function update(AddresseUserRequest $request, AddresseUser $addressesUser): RedirectResponse
    {
        $addressesUser->update($request->validated());
        return Redirect::route('addresses_users.index')->with('success', '¡La dirección de envío ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        AddresseUser::findOrFail($id)->delete();
        return Redirect::route('addresses_users.index')->with('success', '¡La dirección de envío ha sido eliminada correctamente!');
    }
}