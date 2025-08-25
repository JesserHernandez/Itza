<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MovementRequest;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MovementController extends Controller
{
    public function index(Request $request): mixed
    {
        $movements = Movement::with(['inventory.product', 'user'])->latest()->paginate();
        return Inertia::render('Movement/Index', ['movements' => $movements, 'i' => ($request->input('page', 1) - 1) * $movements->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Movement/Create', ['movement' => new Movement() ]);
    }
    public function store(MovementRequest $request): RedirectResponse
    {   
        try {
            DB::transaction(function () use ($request) {
                $movement = $request->validated();
                $user = Auth::user();

                $inventory = Inventory::findOrFail($movement['inventory_id']);

                if ($movement['movement'] === 'Inventario Inicial') {
                    $inventory->initial_existence = $movement['quantity'];
                    $inventory->balanced_existence = $movement['quantity'];
                }

                if ($movement['movement'] === 'Entrada') {
                    $inventory->balanced_existence += $movement['quantity'];
                } else {
                    if ($inventory->balanced_existence < $movement['quantity']) {
                        return Redirect::route('movements.index')->with('error', value: '¡No hay suficiente existencia para realizar el movimiento!');
                    }
                    $inventory->balanced_existence -= $movement['quantity'];
                }

                $inventory->last_movement_date = $movement['date'];
                $inventory->balancing_status = $inventory->balanced_existence < $inventory->minimum_balance ? 'Bajo' : 'Normal';
                $inventory->save();

                Movement::create([
                    ...$movement,
                    'user_id' => $user->id,
                ]);
            });
            
            return Redirect::route('movements.index')->with('success', '¡El movimiento se ha registrado correctamente!');
            
        } catch (\Throwable $th) {
            return Redirect::route('movements.index')->with( 'error','¡Vaya!... Ocurrió el siguiente error al registrar el movimiento: ' . $th->getMessage());
        }
    }
    public function show($id): mixed
    {
        $movement = Movement::findOrFail($id);
        return Inertia::render('Movement/Show', ['movement' => $movement ]);
    }
    public function edit($id): mixed
    {
        $movement = Movement::findOrFail($id);
        return Inertia::render('Movement/Edit', ['movement' => $movement ]);
    }
    public function update(MovementRequest $request, Movement $movement): RedirectResponse
    {

        try {
            DB::transaction(function () use ($request, $movement) {
                $validated = $request->validated();

                $inventory = $movement->inventory;

                if ($validated['movement'] === 'Inventario Inicial') {
                    $inventory->initial_existence = $movement->quantity;
                    $inventory->balanced_existence = $movement->quantity;
                }

                if ($movement->movement === 'Entrada') {
                    $inventory->balanced_existence -= $movement->quantity;
                } else {
                    $inventory->balanced_existence += $movement->quantity;
                }

                if ($validated['movement'] === 'Entrada') {
                    $inventory->balanced_existence += $validated['quantity'];
                } else {
                    if ($inventory->balanced_existence < $validated['quantity']) {
                        return Redirect::route('movements.index')->with('error', '¡No hay suficiente existencia para realizar el movimiento!');
                    }
                    $inventory->balanced_existence -= $validated['quantity'];
                }

                $inventory->last_movement_date = $validated['date'];
                $inventory->balancing_status = $inventory->balanced_existence < $inventory->minimum_balance ? 'Bajo' : 'Normal';
                $inventory->save();

                $movement->update([
                    ...$validated,
                ]);
            });
            return Redirect::route('movements.index')->with('success', '¡El movimiento se ha actualizado correctamente!');

        } catch (\Throwable $th) {
            return Redirect::route('movements.index')->with( 'error','¡Vaya!... Ocurrió el siguiente error al actualizar el movimiento: ' . $th->getMessage());
        }
    }
    public function destroy(Movement $movement): RedirectResponse
    {
        $movement->delete();
        return Redirect::route('movements.index')->with('success', '¡Movimiento eliminado correctamente!');
    }
}