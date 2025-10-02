<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $hasDeliveredOrders = Auth::user()->orders()->where('order_status', 'Entregada')->exists();
                $validated['is_verified_purchase'] = $hasDeliveredOrders;

                $review = Review::create($validated);

                foreach ($validated['images'] as $imageData) {
                    $review->images()->create($imageData);
                }
            });
            return Redirect::route('reviews.index')->with('success', '¡La reseña ha sido guardada correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('reviews.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la reseña. Inténtalo de nuevo.');
        }
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
        try {
            DB::transaction(function () use ($request, $review) {
                $validated = $request->validated();
                $hasDeliveredOrders = Auth::user()->orders()->where('order_status', 'Entregada')->exists();
                $validated['is_verified_purchase'] = $hasDeliveredOrders;

                $review->update($validated);

                $existingImages = $review->images()->get()->keyBy('id');
                $incomingIds = collect($validated['images'] ?? [])->pluck('id')->filter()->all();
                $review->images()->whereNotIn('id', $incomingIds)->delete();

                foreach ($validated['images'] ?? [] as $imageData) {
                    if (isset($imageData['id']) && $existingImages->has($imageData['id'])) {
                        $existingImages[$imageData['id']]->update(Arr::except($imageData, ['id']));
                    } else {
                        $review->images()->create($imageData);
                    }
                }
            });
            return Redirect::route('reviews.index')->with('success', '¡La reseña ha sido guardada correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('reviews.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la reseña. Inténtalo de nuevo.');
        }
    }
    public function destroy($id): RedirectResponse
    {
        Review::findOrFail($id)->delete();
        return Redirect::route('reviews.index')->with('success', '¡La reseña ha sido eliminada correctamente!');
    }
}