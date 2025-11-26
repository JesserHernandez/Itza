<?php

namespace App\Http\Controllers;

use App\Models\CreativeCity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreativeCityRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CreativeCityController extends Controller
{
    public function index(Request $request): mixed
    {
        $creativeCities = CreativeCity::paginate();
        return Inertia::render('Administrator/CreativeCity/Index', ['creative_cities' => $creativeCities, 'i' => ($request->input('page', 1) - 1) * $creativeCities->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Administrator/CreativeCity/Create', ['creative_city' => new CreativeCity()]);
    }
    public function store(CreativeCityRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        CreativeCity::create($validated);
        return Redirect::route('creative_cities.index')->with('success', '¡La ciudad creativa ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $creativeCity = CreativeCity::findOrFail($id);
        return Inertia::render('Administrator/CreativeCity/Show', ['creative_city' => $creativeCity ]);
    }
    public function edit($id): mixed
    {
        $creativeCity = CreativeCity::findOrFail($id);
        return Inertia::render('Administrator/CreativeCity/Edit', ['creative_city' => $creativeCity ]);
    }
    public function update(CreativeCityRequest $request, CreativeCity $creativeCity): RedirectResponse
    {
        $creativeCity->update($request->validated());
        return Redirect::route('creative_cities.index')->with('success', '¡La ciudad creativa ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        CreativeCity::findOrFail($id)->delete();
        return Redirect::route('creative_cities.index')->with('success', '¡La ciudad creativa ha sido eliminada correctamente!');
    }
}