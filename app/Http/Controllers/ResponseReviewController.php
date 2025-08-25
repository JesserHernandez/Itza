<?php

namespace App\Http\Controllers;

use App\Models\ResponseReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ResponseReviewRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ResponseReviewController extends Controller
{
    public function index(Request $request): mixed
    {
        $responseReviews = ResponseReview::paginate();
        return Inertia::render('ResponseReview/Index', ['responseReviews' => $responseReviews, 'i' => ($request->input('page', 1) - 1) * $responseReviews->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('ResponseReview/Create', ['responseReview' => new ResponseReview() ]);
    }
    public function store(ResponseReviewRequest $request): RedirectResponse
    {
        ResponseReview::create($request->validated());
        return Redirect::route('response-reviews.index')->with('success', '¡La respuesta ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $responseReview = ResponseReview::findOrFail($id);
        return Inertia::render('ResponseReview/Show', ['responseReview' => $responseReview ]);
    }
    public function edit($id): mixed
    {
        $responseReview = ResponseReview::findOrFail($id);
        return Inertia::render('ResponseReview/Edit', ['responseReview' => $responseReview ]);
    }
    public function update(ResponseReviewRequest $request, ResponseReview $responseReview): RedirectResponse
    {
        $responseReview->update($request->validated());
        return Redirect::route('response-reviews.index')->with('success', '¡La respuesta ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        ResponseReview::findOrFail($id)->delete();
        return Redirect::route('response-reviews.index')->with('success', '¡La respuesta ha sido eliminada correctamente!');
    }
}