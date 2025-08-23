<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request): mixed
    {
        $posts = Post::paginate();
        return Inertia::render('Post/Index', ['posts' => $posts, 'i' => ($request->input('page', 1) - 1) * $posts->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Post/Create', ['post' => new Post() ]);
    }
    public function store(PostRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $validated['author_Id'] = Auth::id();
                $validated['team_id'] = Auth::user()->current_team_id;

                $post = Post::create($validated);

                $tagData = collect($validated['tags'] ?? [])->mapWithKeys(fn($t) => [
                    $t['id'] => ['is_main' => $t['is_main'] ?? false],
                ]);

                $mainTagCount = $tagData->filter(fn($t) => $t['is_main'])->count();
                if ($mainTagCount > 1) {
                    return Redirect::route('posts.index')->with('error', '¡Vaya!... Solo una etiqueta puede ser principal. Inténtalo de nuevo.');
                }
                $post->tags()->sync($tagData);


                $categoryData = collect($validated['categories'] ?? [])->mapWithKeys(fn($c) => [
                    $c['id'] => ['is_main' => $c['is_main'] ?? false],
                ]);

                $mainCount = $categoryData->filter(fn($c) => $c['is_main'])->count();
                if ($mainCount > 1) {
                    return Redirect::route('posts.index')->with('error', '¡Vaya!... Solo una categoria puede ser principal. Inténtalo de nuevo.');
                }
                $post->categories()->sync($categoryData);

                foreach ($validated['images'] ?? [] as $image) {
                    $post->images()->create([
                        'photo_path' => $image['photo_path'] ?? null,
                        'is_main'    => $image['is_main'] ?? false,
                    ]);
                }
            });

            return Redirect::route('posts.index')->with('success', '¡La publicación ha sido guardada correctamente!');
    
        } catch (\Throwable $th) {
            return Redirect::route('orders.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la publicación. Inténtalo de nuevo.');
        }
    }
    public function show($id): mixed
    {
        $post = Post::findOrFail($id);
        return Inertia::render('Post/Show', ['post' => $post ]);
    }
    public function edit($id): mixed
    {
        $post = Post::findOrFail($id);
        return Inertia::render('Post/Edit', ['post' => $post ]);
    }
    public function update(PostRequest $request, Post $post)
    {
        try {
            DB::transaction(function () use ($request, $post) {
                $validated = $request->validated();
                $post->update($validated);

                $tagData = collect($validated['tags'] ?? [])->mapWithKeys(fn($t) => [
                    $t['id'] => ['is_main' => $t['is_main'] ?? false],
                ]);

                $mainTagCount = $tagData->filter(fn($t) => $t['is_main'])->count();
                if ($mainTagCount > 1) {
                    return Redirect::route('products.index')->with('error', '¡Vaya!... Solo una etiqueta puede ser principal. Inténtalo de nuevo.');
                }

                $post->tags()->sync($tagData);

                $categoryData = collect($validated['categories'] ?? [])->mapWithKeys(fn($c) => [
                    $c['id'] => ['is_main' => $c['is_main'] ?? false],
                ]);

                $mainCategoryCount = $categoryData->filter(fn($c) => $c['is_main'])->count();
                if ($mainCategoryCount > 1) {
                    return Redirect::route('products.index')->with('error', '¡Vaya!... Solo una categoria puede ser principal. Inténtalo de nuevo.');
                }

                $post->categories()->sync($categoryData);

                $incomingImages = collect($request->input('images', []));
                $existingIds = $post->images()->pluck('id')->toArray();
                $incomingIds = $incomingImages->pluck('id')->filter()->toArray();

                $post->images()->whereNotIn('id', $incomingIds)->delete();

                foreach ($incomingImages as $imageData) {
                    if (isset($imageData['id']) && in_array($imageData['id'], $existingIds)) {
                        PostImage::where('id', $imageData['id'])->update([
                            'photo_path' => $imageData['photo_path'] ?? null,
                            'is_main'    => $imageData['is_main'] ?? false,
                        ]);
                    } else {
                        $post->images()->create([
                            'photo_path' => $imageData['photo_path'] ?? null,
                            'is_main'    => $imageData['is_main'] ?? false,
                        ]);
                    }
                }
            });

            return Redirect::route('posts.index')->with('success', '¡La publicación ha sido actualizada correctamente!');
    
        } catch (\Throwable $th) {
            return Redirect::route('orders.index')->with('error', '¡Vaya!... Ocurrió un error al actualizar la publicación. Inténtalo de nuevo.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        Post::findOrFail($id)->delete();
        return Redirect::route('posts.index')->with('success', '¡La publicación ha sido eliminada correctamente!');
    }
}