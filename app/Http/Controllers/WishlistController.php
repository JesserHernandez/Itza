<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistsRequest;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index(Request $request): mixed
    {
        $wishlists = Wishlist::paginate();
        return Inertia::render('Wishlist/Index', ['wishlists' => $wishlists, 'i' => ($request->input('page', 1) - 1) * $wishlists->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Wishlist/Create', ['wishlist' => new Wishlist() ]);
    }
    public function store(WishlistsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        Wishlist::create($validated);
        return Redirect::route('wishlists.index')->with('success', '¡El producto se ha añadido a la lista de deseos correctamente!');
    }
    public function show($id): mixed
    {
        $wishlist = Wishlist::findOrFail($id);
        return Inertia::render('Wishlist/Show', ['wishlist' => $wishlist ]);
    }
    public function edit($id): mixed
    {
        $wishlist = Wishlist::findOrFail($id);
        return Inertia::render('Wishlist/Edit', ['wishlist' => $wishlist ]);
    }
    public function update(WishlistsRequest $request, Wishlist $wishlist): RedirectResponse
    {
        $wishlist->update([$request->validated()]);
        return Redirect::route('wishlists.index')->with('success', '¡El producto se ha actualizado de la lista de deseos correctamente!');
    }
    public function destroy(Wishlist $wishlist): RedirectResponse
    {
        $wishlist->delete();
        return Redirect::route('wishlists.index')->with('success', '¡El producto se ha eliminado de la lista de deseos correctamente!');
    }
}