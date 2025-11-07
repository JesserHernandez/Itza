<?php

namespace App\Http\Controllers;

use App\Models\UserPaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserPaymentMethodRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserPaymentMethodController extends Controller
{
    public function index(Request $request): mixed
    {
        $userPaymentMethods = UserPaymentMethod::paginate();
        return Inertia::render('Customer/UserPaymentMethod/Index', ['userPaymentMethods' => $userPaymentMethods, 'i' => ($request->input('page', 1) - 1) * $userPaymentMethods->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/UserPaymentMethod/Create', ['userPaymentMethod' => new UserPaymentMethod() ]);
    }
    public function store(UserPaymentMethodRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        UserPaymentMethod::create($validated);
        return Redirect::route('payment_methods_users.index')->with('success', '¡El metodo de pago ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $userPaymentMethod = UserPaymentMethod::findOrFail($id);
        return Inertia::render('Customer/UserPaymentMethod/Show', ['userPaymentMethod' => $userPaymentMethod ]);
    }
    public function edit($id): mixed
    {
        $userPaymentMethod = UserPaymentMethod::findOrFail($id);
        return Inertia::render('Customer/UserPaymentMethod/Edit', ['userPaymentMethod' => $userPaymentMethod ]);
    }
    public function update(UserPaymentMethodRequest $request, UserPaymentMethod $userPaymentMethod): RedirectResponse
    {
        $userPaymentMethod->update($request->validated());
        return Redirect::route('payment_methods_users.index')->with('success', '¡El metodo de pago ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        UserPaymentMethod::findOrFail($id)->delete();
        return Redirect::route('payment_methods_users.index')->with('success', '¡El metodo de pago ha sido eliminado correctamente!');
    }
}