<?php

namespace App\Http\Controllers;

use App\Models\ReviewResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewResponseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReviewResponseController extends Controller
{
    public function index(Request $request): mixed
    {
        $ReviewResponses = ReviewResponse::paginate();
        return Inertia::render('Customer/ReviewResponse/Index', ['ReviewResponses' => $ReviewResponses, 'i' => ($request->input('page', 1) - 1) * $ReviewResponses->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/ReviewResponse/Create', ['ReviewResponse' => new ReviewResponse() ]);
    }
    public function store(ReviewResponseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        ReviewResponse::create($validated);
        return Redirect::route('response-reviews.index')->with('success', '¡La respuesta ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $ReviewResponse = ReviewResponse::findOrFail($id);
        return Inertia::render('Customer/ReviewResponse/Show', ['ReviewResponse' => $ReviewResponse ]);
    }
    public function edit($id): mixed
    {
        $ReviewResponse = ReviewResponse::findOrFail($id);
        return Inertia::render('Customer/ReviewResponse/Edit', ['ReviewResponse' => $ReviewResponse ]);
    }
    public function update(ReviewResponseRequest $request, ReviewResponse $ReviewResponse): RedirectResponse
    {
        $ReviewResponse->update($request->validated());
        return Redirect::route('response-reviews.index')->with('success', '¡La respuesta ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        ReviewResponse::findOrFail($id)->delete();
        return Redirect::route('response-reviews.index')->with('success', '¡La respuesta ha sido eliminada correctamente!');
    }
}