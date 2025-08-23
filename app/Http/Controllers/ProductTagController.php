<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductTagRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $productTags = ProductTag::paginate();

        return view('product-tag.index', compact('productTags'))
            ->with('i', ($request->input('page', 1) - 1) * $productTags->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $productTag = new ProductTag();

        return view('product-tag.create', compact('productTag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductTagRequest $request): RedirectResponse
    {
        ProductTag::create($request->validated());

        return Redirect::route('product-tags.index')
            ->with('success', 'ProductTag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $productTag = ProductTag::find($id);

        return view('product-tag.show', compact('productTag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $productTag = ProductTag::find($id);

        return view('product-tag.edit', compact('productTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductTagRequest $request, ProductTag $productTag): RedirectResponse
    {
        $productTag->update($request->validated());

        return Redirect::route('product-tags.index')
            ->with('success', 'ProductTag updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        ProductTag::find($id)->delete();

        return Redirect::route('product-tags.index')
            ->with('success', 'ProductTag deleted successfully');
    }
}
