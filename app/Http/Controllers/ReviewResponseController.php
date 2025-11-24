<?php

namespace App\Http\Controllers;

use App\Models\ReviewResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewResponseRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReviewResponseController extends Controller
{
    public function index(Request $request): mixed
    {
        $reviewResponses = ReviewResponse::paginate();
        return Inertia::render('Customer/ReviewResponse/Index', ['reviewResponses' => $reviewResponses, 'i' => ($request->input('page', 1) - 1) * $reviewResponses->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/ReviewResponse/Create', ['reviewResponse' => new ReviewResponse() ]);
    }
    public function store(ReviewResponseRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $validated['user_id'] = Auth::id();

                $hasDeliveredOrders = Auth::user()->orders()->where('order_status', 'Entregada')->exists();
                $validated['is_verified_purchase'] = $hasDeliveredOrders;

                $reviewResponde = ReviewResponse::create($validated);

                foreach ($validated['images'] as $imageData) {
                    $reviewResponde->images()->create($imageData);
                }
            });
            return Redirect::route('review_responses.index')->with('success', '¡La respuesta ha sido guardada correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('review_responses.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la respuesta. Inténtalo de nuevo.');
        }
    }
    public function show($id): mixed
    {
        $reviewResponse = ReviewResponse::findOrFail($id);
        return Inertia::render('Customer/ReviewResponse/Show', ['reviewResponse' => $reviewResponse ]);
    }
    public function edit($id): mixed
    {
        $reviewResponse = ReviewResponse::findOrFail($id);
        return Inertia::render('Customer/ReviewResponse/Edit', ['reviewResponse' => $reviewResponse ]);
    }
    public function update(ReviewResponseRequest $request, ReviewResponse $reviewResponse): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $reviewResponse) {
                $validated = $request->validated();
                $validated['user_id'] = Auth::id();
                
                $hasDeliveredOrders = Auth::user()->orders()->where('order_status', 'Entregada')->exists();
                $validated['is_verified_purchase'] = $hasDeliveredOrders;

                $reviewResponse->update($validated);

                $existingImages = $reviewResponse->images()->get()->keyBy('id');
                $incomingIds = collect($validated['images'] ?? [])->pluck('id')->filter()->all();
                $reviewResponse->images()->whereNotIn('id', $incomingIds)->delete();

                foreach ($validated['images'] ?? [] as $imageData) {
                    if (isset($imageData['id']) && $existingImages->has($imageData['id'])) {
                        $existingImages[$imageData['id']]->update(Arr::except($imageData, ['id']));
                    } else {
                        $reviewResponse->images()->create($imageData);
                    }
                }
            });
            return Redirect::route('review_responses.index')->with('success', '¡La respuesta ha sido guardada correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('review_responses.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la respuesta. Inténtalo de nuevo.');
        }
    }
    public function destroy($id): RedirectResponse
    {
        ReviewResponse::findOrFail($id)->delete();
        return Redirect::route('review_responses.index')->with('success', '¡La respuesta ha sido eliminada correctamente!');
    }
}