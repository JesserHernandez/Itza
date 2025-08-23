<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index(Request $request): mixed
    {
        $coupons = Coupon::paginate();
        return Inertia::render( 'Coupon/Index', ['coupons' => $coupons, 'i' => ($request->input('page', 1) - 1) * $coupons->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Coupon/Create', ['coupon' => new Coupon() ]);
    }
    public function store(CouponRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['team_id'] = Auth::user()->current_team_id;
        $validated['code'] = 'COU-' . strtoupper(Str::uuid());
        Coupon::create($validated);
        return Redirect::route('coupons.index')->with('success', '¡El cupón ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $coupon = Coupon::findOrFail($id);
        return Inertia::render('Coupon/Show', ['coupon' => $coupon ]);
    }
    public function edit($id): mixed
    {
        $coupon = Coupon::findOrFail($id);
        return Inertia::render('Coupon/Edit', ['coupon' => $coupon ]);
    }
    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $coupon->update($request->validated());
        return Redirect::route('coupons.index')->with('success', '¡El cupón ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Coupon::findOrFail($id)->delete();
        return Redirect::route('coupons.index')->with('success', '¡El cupón ha sido eliminado correctamente!');
    }
}