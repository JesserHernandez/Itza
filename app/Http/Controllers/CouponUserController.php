<?php

namespace App\Http\Controllers;

use App\Models\CouponUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CouponUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CouponUserController extends Controller
{
    public function index(Request $request): mixed
    {
        $couponUsers = CouponUser::paginate();
        return Inertia::render( 'Customer/CouponUser/Index', ['coupon_users' => $couponUsers, 'i' => ($request->input('page', 1) - 1) * $couponUsers->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/CouponUser/Create', ['coupon_user' => new CouponUser() ]);
    }
    public function store(CouponUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        CouponUser::create($validated);
        return Redirect::route('coupon_users.index')->with('success', '¡El cupón ha sido canjeado correctamente!');
    }
    public function show($id): mixed
    {
        $couponUser = CouponUser::findOrFail($id);
        return Inertia::render('Customer/CouponUser/Show', ['coupon_user' => $couponUser ]);
    }
    public function edit($id): mixed
    {
        $couponUser = CouponUser::findOrFail($id);
        return Inertia::render('Customer/CouponUser/Edit', ['coupon_user' => $couponUser ]);
    }
    public function update(CouponUserRequest $request, CouponUser $couponUser): RedirectResponse
    {
        $couponUser->update($request->validated());
        return Redirect::route('coupon_users.index')->with('success', '¡El cupón ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        CouponUser::findOrFail($id)->delete();
        return Redirect::route('coupon_users.index')->with('success', '¡El cupón ha sido eliminado correctamente!');
    }
}