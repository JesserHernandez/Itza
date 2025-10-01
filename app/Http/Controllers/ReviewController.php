<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function index(Request $request): mixed
    {
        $reviews = Review::paginate();
        return Inertia::render('Customer/Review/Index', ['reviews' => $reviews, 'i' => ($request->input('page', 1) - 1) * $reviews->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/Review/Create', ['review' => new Review() ]);
    }
    public function store(ReviewRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $hasDeliveredOrders = Auth::user()->orders()->where('order_status', 'Entregada')->exists();
        $validated['is_verified_purchase'] = $hasDeliveredOrders;

        $review = Review::create($validated);
        if ($validated->hasFile('photo_path')) {
            $review->photo_path = $validated->file('photo_path')->store('reviews', 'public');
        }
        $review->save();

        return Redirect::route('reviews.index')->with('success', '¡La reseña ha sido guardada correctamente!');
    }
    
    public function show($id): mixed
    {
        $review = Review::findOrFail($id);
        return Inertia::render('Customer/Review/Show', ['review' => $review ]);
    }
    public function edit($id): mixed
    {
        $review = Review::findOrFail($id);
        return Inertia::render('Customer/Review/Edit', ['review' => $review ]);
    }
    public function update(ReviewRequest $request, Review $review): RedirectResponse
    {
        $validated = $request->validated();
        $hasDeliveredOrders = Auth::user()->orders()->where('order_status', 'Entregada')->exists();
        $validated['is_verified_purchase'] = $hasDeliveredOrders;

        $review = Review::create($validated);
        if ($validated->hasFile('photo_path')) {
            $review->photo_path = $validated->file('photo_path')->store('reviews', 'public');
        }
        $review->save();

        $review->update($request->validated());
        return Redirect::route('reviews.index')->with('success', '¡La reseña ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Review::findOrFail($id)->delete();
        return Redirect::route('reviews.index')->with('success', '¡La reseña ha sido eliminada correctamente!');
    }
}