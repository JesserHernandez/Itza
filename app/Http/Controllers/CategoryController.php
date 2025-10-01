<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request): mixed
    {
        $categories = Category::paginate();
        return Inertia::render('Vendor/Category/Index', ['categories' => $categories, 'i' => ($request->input('page', 1) - 1) * $categories->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Vendor/Category/Create', ['category' => new Category() ]);
    }
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());
        return Redirect::route('categories.index')->with('success', '¡La categoria ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $category = Category::findOrFail($id);
        return Inertia::render('Vendor/Category/Show', ['category' => $category ]);
    }
    public function edit($id): mixed
    {
        $category = Category::findOrFail($id);
        return Inertia::render('Vendor/Category/Edit', ['category' => $category ]);
    }
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        return Redirect::route('categories.index')->with('success', '¡La categoria ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Category::findOrFail($id)->delete();
        return Redirect::route('categories.index')->with('success', '¡La categoria ha sido eliminada correctamente!');
    }
}