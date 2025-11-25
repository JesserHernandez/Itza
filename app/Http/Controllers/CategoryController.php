<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\CategoryAttribute;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request): mixed
    {
        $categories = Category::with('categoryAttributes')->paginate();
        return Inertia::render('Vendor/Category/Index', ['categories' => $categories, 'i' => ($request->input('page', 1) - 1) * $categories->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Vendor/Category/Create', ['category' => new Category(), ['category_atributtes' => new CategoryAttribute()] ]);
    }
    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        foreach ($request['category_attributes'] as $attr) {
        CategoryAttribute::create([
            'category_name'   => $attr['category_name'],
            'label'           => $attr['label'],
            'data_type'       => $attr['data_type'],
            'unit'            => $attr['unit'],
            'category_id'     => $category->id,
        ]);
    }
        return Redirect::route('categories.index')->with('success', '¡La categoria ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $category = Category::findOrFail($id);
        $categoryAttributes = CategoryAttribute::all();
        return Inertia::render('Vendor/Category/Show', ['category' => $category, 'category_attributes' => $categoryAttributes ]);
    }
    public function edit($id): mixed
    {
        $category = Category::findOrFail($id);
        $categoryAttributes = CategoryAttribute::all();
        return Inertia::render('Vendor/Category/Edit', ['category' => $category, 'category_attributes' => $categoryAttributes]);
    }
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        $category->update($validated);

        $existingIds = $category->categoryAttributes()->pluck('id')->toArray();
        $incomingIds = collect($validated['category_attributes'])->pluck('id')->filter()->toArray();

        $idsToDelete = array_diff($existingIds, $incomingIds);
        CategoryAttribute::whereIn('id', $idsToDelete)->delete();

        foreach ($validated['category_attributes'] as $attr) {

            if (!empty($attr['id'])) {
                CategoryAttribute::where('id', $attr['id'])->update([
                    'category_name' => $attr['category_name'],
                    'label'        => $attr['label'],
                    'data_type'    => $attr['data_type'],
                    'unit'         => $attr['unit'],
                ]);
            } 
            else {
                $category->categoryAttributes()->create([
                    'category_name' => $attr['category_name'],
                    'label'        => $attr['label'],
                    'data_type'    => $attr['data_type'],
                    'unit'         => $attr['unit'],
                ]);
            }
        }
        return Redirect::route('categories.index')->with('success', '¡La categoria ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Category::findOrFail($id)->delete();
        return Redirect::route('categories.index')->with('success', '¡La categoria ha sido eliminada correctamente!');
    }
}