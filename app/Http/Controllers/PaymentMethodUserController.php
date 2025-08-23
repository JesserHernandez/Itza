<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethodUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentMethodUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PaymentMethodUserController extends Controller
{
    public function index(Request $request): mixed
    {
        $paymentMethodUsers = PaymentMethodUser::paginate();
        return Inertia::render('PaymentMethodUser/Index', ['paymentMethodUsers' => $paymentMethodUsers, 'i' => ($request->input('page', 1) - 1) * $paymentMethodUsers->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('PaymentMethodUser/Create', ['paymentMethodUser' => new PaymentMethodUser() ]);
    }
    public function store(PaymentMethodUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        PaymentMethodUser::create($validated);
        return Redirect::route('payment-method-users.index')->with('success', '¡El metodo de pago ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $paymentMethodUser = PaymentMethodUser::findOrFail($id);
        return Inertia::render('PaymentMethodUser/Show', ['paymentMethodUser' => $paymentMethodUser ]);
    }
    public function edit($id): mixed
    {
        $paymentMethodUser = PaymentMethodUser::findOrFail($id);
        return Inertia::render('PaymentMethodUser/Edit', ['paymentMethodUser' => $paymentMethodUser ]);
    }
    public function update(PaymentMethodUserRequest $request, PaymentMethodUser $paymentMethodUser): RedirectResponse
    {
        $paymentMethodUser->update($request->validated());
        return Redirect::route('payment-method-users.index')->with('success', '¡El metodo de pago ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        PaymentMethodUser::findOrFail($id)->delete();
        return Redirect::route('payment-method-users.index')->with('success', '¡El metodo de pago ha sido eliminado correctamente!');
    }
}