<?php

namespace App\Http\Controllers;

use App\Models\CreativeCircuit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreativeCircuitRequest;
use App\Models\CreativeCity;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CreativeCircuitController extends Controller
{
    public function index(Request $request): mixed
    {
        $creativeCircuits = CreativeCircuit::paginate();
        return Inertia::render('Administrator/CreativeCircuit/Index', ['creative_circuits' => $creativeCircuits, 'i' => ($request->input('page', 1) - 1) * $creativeCircuits->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Administrator/CreativeCircuit/Create', ['creative_circuit' => new CreativeCircuit(), 'creative_city' => CreativeCity::all() ]);
    }
    public function store(CreativeCircuitRequest $request): RedirectResponse
    {
        CreativeCircuit::create($request->validated());
        return Redirect::route('creative_circuits.index')->with('success', '¡El circuito creativo ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $creativeCircuit = CreativeCircuit::findOrFail($id);
        return Inertia::render('Administrator/CreativeCircuit/Show', ['creative_circuit' => $creativeCircuit, 'creative_city' => CreativeCity::all() ]);
    }
    public function edit($id): mixed
    {
        $creativeCircuit = CreativeCircuit::findOrFail($id);
        return Inertia::render('Administrator/CreativeCircuit/Edit', ['creative_circuit' => $creativeCircuit, 'creative_city' => CreativeCity::all() ]);
    }
    public function update(CreativeCircuitRequest $request, CreativeCircuit $creativeCircuit): RedirectResponse
    {
        $creativeCircuit->update($request->validated());
        return Redirect::route('creative_circuits.index')->with('success', '¡El circuito creativo ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        CreativeCircuit::findOrFail($id)->delete();
        return Redirect::route('creative_circuits.index')->with('success', '¡El circuito creativo ha sido eliminado correctamente!');
    }
}