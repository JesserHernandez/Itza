<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Request $request): mixed
    {
        $tags = Tag::paginate();
        return Inertia::render('Tag/Index', ['tags' => $tags, 'i' => ($request->input('page', 1) - 1) * $tags->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Tag/Create', ['tag' => new Tag() ]);
    }
    public function store(TagRequest $request): RedirectResponse
    {
        Tag::create($request->validated());
        return Redirect::route('tags.index')->with('success', '¡El tag ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $tag = Tag::findOrFail($id);
        return Inertia::render('Tag/Show', ['tag' => $tag ]);
    }
    public function edit($id): mixed
    {
        $tag = Tag::findOrFail($id);
        return Inertia::render('Tag/Edit', ['tag' => $tag ]);
    }
    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
        $tag->update($request->validated());
        return Redirect::route('tags.index')->with('success', '¡El tag ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Tag::findOrFail($id)->delete();
        return Redirect::route('tags.index')->with('success', '¡El tag ha sido actualizado correctamente!');
    }
}