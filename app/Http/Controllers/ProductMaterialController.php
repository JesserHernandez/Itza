<?php

namespace App\Http\Controllers;

use App\Models\ProductMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductMaterialRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductMaterialController extends Controller
{
    public function index(Request $request): mixed
    {
        $productMaterials = ProductMaterial::paginate();
        return Inertia::render('Vendor/ProductMaterial/Index', ['productMaterials' => $productMaterials, 'i' => ($request->input('page', 1) - 1) * $productMaterials->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Vendor/ProductMaterial/Create', ['productMaterial' => new ProductMaterial() ]);
    }
    public function store(ProductMaterialRequest $request): RedirectResponse
    {
        ProductMaterial::create($request->validated());
        return Redirect::route('product_materials.index')->with('success', '¡El material del producto ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $productMaterial = ProductMaterial::findOrFail($id);
        return Inertia::render('Vendor/ProductMaterial/Show', ['productMaterial' => $productMaterial ]);
    }
    public function edit($id): mixed
    {
        $productMaterial = ProductMaterial::findOrFail($id);
        return Inertia::render('Vendor/ProductMaterial/Edit', ['productMaterial' => $productMaterial ]);
    }
    public function update(ProductMaterialRequest $request, ProductMaterial $productMaterial): RedirectResponse
    {
        $productMaterial->update($request->validated());
        return Redirect::route('product_materials.index')->with('success', '¡El material del producto ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        ProductMaterial::findOrFail($id)->delete();
        return Redirect::route('product_materials.index')->with('success', '¡El material del producto ha sido eliminado correctamente!');
    }
}