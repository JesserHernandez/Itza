<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request): mixed
    {
        $products = Product::paginate();
        return Inertia::render('Vendor/Product/Index', ['products' => $products, 'i' => ($request->input('page', 1) - 1) * $products->perPage()]);
    }
    public function create(): mixed
    {
        $categories = Category::all();
        $tags = Tag::all();
        $materials = ProductMaterial::all() ;
        return Inertia::render('Vendor/Product/Create', [
            'product' => new Product(), 'categories' => $categories, 'tags' => $tags, 'materials' => $materials
        ]);
    }
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $product = Product::create($validated);
                $product->productPriceHistories()->create(['old_price' => $product->price,'changing_user_id' => Auth::id() ]);

                $materialData = collect($validated['materials'] ?? [])
                    ->mapWithKeys(fn($id, $index) => [
                        $id => ['is_main' => $index === 0],
                    ]);
                $product->materialProducts()->sync($materialData);

                $tagData = collect($validated['tags'] ?? [])
                    ->mapWithKeys(fn($id, $index) => [
                        $id => ['is_main' => $index === 0],
                    ]);
                $product->productTags()->sync($tagData);

                $categoryData = collect($validated['categories'] ?? [])
                    ->mapWithKeys(fn($id, $index) => [
                        $id => ['is_main' => $index === 0],
                    ]);
                $product->categoryProducts()->sync($categoryData);

                foreach ($validated['photo_paths'] ?? [] as $index => $uploadedFile) {
                    $path = $uploadedFile->store('products', 'public');

                    $product->productImages()->create([
                        'photo_path' => $path,
                        'is_main' => $index === 0,
                    ]);
                }
            });

            return Redirect::route('products.index')->with('success', '¡El producto ha sido guardado correctamente!');
    
        } catch (\Throwable $th) {
            return Redirect::route('products.index')->with('error', '¡Vaya!... Ocurrió un error al actualizar la publicación. Inténtalo de nuevo.!');
        }
    }
    public function show($id): mixed
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Vendor/Product/Show', ['product' => $product ]);

    }
    public function edit($id): mixed
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Vendor/Product/Edit', ['product' => $product ]);
    }
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $validated = $request->validated();

                $product->update($validated);

                if ($product->wasChanged('price')) {
                    $product->productPriceHistories()->create([
                        'old_price' => $product->getOriginal('price'),
                        'changing_user_id' => Auth::id(),
                    ]);
                }

                $materialData = collect($validated['materials'] ?? [])->mapWithKeys(fn($m) => [
                    $m['id'] => ['is_main' => $m['is_main'] ?? false],
                ]);

                $mainMaterialCount = $materialData->filter(fn($m) => $m['is_main'])->count();
                if ($mainMaterialCount > 1) {
                    return Redirect::route('products.index')->with('error', '¡Vaya!... Solo un material puede ser principal. Inténtalo de nuevo.');
                }

                $product->materialProducts()->sync($materialData);

                $tagData = collect($validated['tags'] ?? [])->mapWithKeys(fn($t) => [
                    $t['id'] => ['is_main' => $t['is_main'] ?? false],
                ]);

                $mainTagCount = $tagData->filter(fn($t) => $t['is_main'])->count();
                if ($mainTagCount > 1) {
                    return Redirect::route('products.index')->with('error', '¡Vaya!... Solo una etiqueta puede ser principal. Inténtalo de nuevo.');
                }

                $product->productTags()->sync($tagData);

                $categoryData = collect($validated['categories'] ?? [])->mapWithKeys(fn($c) => [
                    $c['id'] => ['is_main' => $c['is_main'] ?? false],
                ]);

                $mainCategoryCount = $categoryData->filter(fn($c) => $c['is_main'])->count();
                if ($mainCategoryCount > 1) {
                    return Redirect::route('products.index')->with('error', '¡Vaya!... Solo una categoria puede ser principal. Inténtalo de nuevo.');
                }

                $product->categoryProducts()->sync($categoryData);

                $incomingImages = collect($request->input('images', []));
                $existingIds = $product->productImages()->pluck('id')->toArray();
                $incomingIds = $incomingImages->pluck('id')->filter()->toArray();

                $product->productImages()->whereNotIn('id', $incomingIds)->delete();

                foreach ($incomingImages as $imageData) {
                    if (isset($imageData['id']) && in_array($imageData['id'], $existingIds)) {
                        ProductImage::where('id', $imageData['id'])->update([
                            'photo_path' => $imageData['photo_path'] ?? null,
                            'is_main'    => $imageData['is_main'] ?? false,
                        ]);
                    } else {
                        $product->images()->create([
                            'photo_path' => $imageData['photo_path'] ?? null,
                            'is_main'    => $imageData['is_main'] ?? false,
                        ]);
                    }
                }
            });

            return Redirect::route('products.index')->with('success', '¡El producto ha sido guardado correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('products.index')->with('error', '¡Vaya!... Ocurrió un error al actualizar la publicación. Inténtalo de nuevo.!');
        }
    }
    public function destroy($id): RedirectResponse
    {
        Product::findOrFail($id)->delete();
        return Redirect::route('products.index')->with('success', '¡El producto ha sido eliminado correctamente!');
    }
}