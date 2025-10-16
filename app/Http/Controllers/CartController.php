<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartDetailRequest;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(Request $request): mixed
    {
        $carts = Cart::paginate();
        return Inertia::render('Customer/Cart/Index', ['carts' => $carts, 'i' => ($request->input('page', 1) - 1) * $carts->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/Cart/Create', ['cart' => new Cart() ]);
    }
    public function store(CartRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                
                $validated = $request->validated();
                $cartExists = Cart::where('user_id', Auth::id())->exists();
            
                if ($cartExists === false) {
                    Cart::firstOrCreate(["user_id" => Auth::id()]);  
                }
                $cart = Cart::where('user_id', Auth::id())->first();
                $cart->cartDetails()->create($validated);

                $cartDetail = CartDetail::where('cart_id', $cart->id)->where('product_id', $validated['product_id'])->first();

                if ($validated['operation']) {
                    $cartDetail->increment('quantity');
                } else {
                    $cartDetail->quantity <= 1 ? $cartDetail->delete() : $cartDetail->decrement('quantity');
                }
            });

            return Redirect::route('carts.index')->with('success', '¡El producto se ha agregado al carrito de compras correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('carts.index')->with( 'error','¡Vaya!... Ocurrió un error al guardar la orden. Inténtalo de nuevo.');
        }
    }
    public function show($id): mixed
    {
        $cart = Cart::findOrFail($id);
        return Inertia::render('Customer/Cart/Show', ['cart' => $cart ]);
    }
    public function edit($id): mixed
    {
        $cart = Cart::findOrFail($id);
        return Inertia::render('Customer/Cart/Edit', ['cart' => $cart ]);
    }
    public function update(CartRequest $request, Cart $cart): RedirectResponse
    {
        $cart->update($request->validated());
        return Redirect::route('carts.index')->with('success', '¡Cantidad actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        CartDetail::findOrFail($id)->delete();
        return Redirect::route('carts.index')->with('success', '¡El producto se ha eliminado del carrito de compras correctamente!');
    }
}