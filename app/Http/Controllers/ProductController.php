<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Tag;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
        ->with([
            'categoryProducts:id,name',
            'productTags:id,name',
            'productImages:id,photo_path,product_id',
            'productAttributeValues:id,product_id,category_attribute_id,value_text,value_number,value_boolean,value_date'
        ]);
        $products = $query->orderBy('name')->paginate();
        return Inertia::render('Vendor/Product/Index', ['products' => $products]);
    }
    public function create(): mixed
    {
        $categories = Category::all();
        $tags = Tag::all();
        $categoryAttributes = CategoryAttribute::all();
        return Inertia::render('Vendor/Product/Create', [
            'product' => new Product(), 'categories' => $categories, 'tags' => $tags, 'category_attributes' => $categoryAttributes
        ]);
    }
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $validated['team_id'] = Auth::user()->current_team_id;

                $product = Product::create($validated);
                $product->productPriceHistories()->create(['old_price' => $product->price,'changing_user_id' => Auth::id() ]);

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
                foreach ($validated['category_attributes'] ?? [] as $attr) {
                $categoryAttributes = $product->categoryProducts()->with('categoryAttributes')->get()->flatMap->categoryAttributes->firstWhere('id', $attr['id']);

                    if ($categoryAttributes) {
                        ProductAttributeValue::create([
                            'product_id' => $product->id,
                            'category_attribute_id' => $categoryAttributes->id,
                            $this->resolveValueField($categoryAttributes->data_type) => $attr['value'],
                        ]);
                    }
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
        $categories = Category::all();
        $tags = Tag::all();
        $categoryAttributes = CategoryAttribute::all();
        return Inertia::render('Vendor/Product/Show', [
            'product' => $product, 'categories' => $categories, 'tags' => $tags, 'category_attributes' => $categoryAttributes
        ]);
    }
    public function edit($id): mixed
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $categoryAttributes = CategoryAttribute::all();
        return Inertia::render('Vendor/Product/Edit', [
            'product' => $product, 'categories' => $categories, 'tags' => $tags, 'category_attributes' => $categoryAttributes
        ]);
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

                $incomingImages = collect($validated['photo_paths'] ?? []);
                $incomingIdImages = $incomingImages->pluck('id')->filter()->toArray();
                $existingIdImages = $product->productImages()->pluck('id')->toArray();

                $product->productImages()->whereNotIn('id', $incomingIdImages)->delete();

                $hasMainImage = $product->productImages()->where('is_main', true)->exists();

                foreach ($incomingImages as $index => $imageData) {

                    $isMain = false;
                    if (!$hasMainImage && $index === 0) {
                        $isMain = true;
                        $hasMainImage = true;
                    }

                    if (isset($imageData['id']) && in_array($imageData['id'], $existingIdImages)) {
                        ProductImage::where('id', $imageData['id'])->update([
                            'photo_path' => $imageData['photo_path'] ?? null,
                            'is_main'    => $isMain,
                        ]);
                    } else {
                        $product->productImages()->create([
                            'photo_path' => $imageData['photo_path'] ?? null,
                            'is_main'    => $isMain,
                        ]);
                    }
                }

                $incomingCategoryAttributes = collect($validated['category_attributes'] ?? []);
                $incomingCategoryAttributeId = $incomingCategoryAttributes->pluck('id')->filter()->toArray();
                $product->productAttributeValues()->whereNotIn('category_attribute_id', $incomingCategoryAttributeId)->delete();

                foreach ($incomingCategoryAttributes as $attr) {

                    $categoryAttributes = $product->categoryProducts()->with('categoryAttributes')->get()->flatMap->categoryAttributes->firstWhere('id', $attr['id']);
                    if (!$categoryAttributes) continue;

                    $valueField = $this->resolveValueField($categoryAttributes->data_type);

                    $existingValue = $product->productAttributeValues()->where('category_attribute_id', $categoryAttributes->id)->first();

                    if ($existingValue) {
                        $existingValue->update([
                            $valueField => $attr['value'],
                            'value_text' => $valueField === 'value_text' ? $attr['value'] : null,
                            'value_number' => $valueField === 'value_number' ? $attr['value'] : null,
                            'value_boolean' => $valueField === 'value_boolean' ? $attr['value'] : null,
                            'value_date' => $valueField === 'value_date' ? $attr['value'] : null,
                        ]);
                    } else {
                        $product->productAttributeValues()->create([
                            'category_attribute_id' => $categoryAttributes->id,
                            $valueField => $attr['value'],
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
    private function resolveValueField(string $type): string
    {
        return match ($type) {
            'text' => 'value_text',
            'number', 'decimal' => 'value_number',
            'boolean' => 'value_boolean',
            'date' => 'value_date',
            default => 'value_text',
        };
    }
}