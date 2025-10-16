<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;
use App\Models\Movement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Else_;

class InventoryController extends Controller
{
    public function index(Request $request): mixed
    {
        $inventories = Inventory::paginate();
        return Inertia::render('Vendor/Inventory/Index', ['inventories' => $inventories, 'i' => ($request->input('page', 1) - 1) * $inventories->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Vendor/Inventory/Create', ['inventory' => new Inventory() ]);
    }

    public function store(InventoryRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $teamId = Auth::user()->current_team_id;

                if ($validated['movement'] === 'Entrada') {
                    if ($validated['type_movement'] === 'Inventario Inicial') {
                        $inventory = Inventory::create([
                            'initial_existence' => $validated['quantity'],
                            'current_balance' => $validated['quantity'],
                            'minimum_balance' => $validated['minimum_balance'],
                            'balancing_status' => $validated['quantity'] < $validated['minimum_balance'] ? 'Bajo' : 'Alto',
                            'is_active' => true,
                            'product_id' => $validated['product_id'],
                            'team_id' => $teamId,
                        ]);
                    } else {
                        $inventory = Inventory::where('product_id', $validated['product_id'])->where('team_id', $teamId)->firstOrFail();

                        if ($inventory->current_balance < $validated['quantity']) {
                            return Redirect::route('movements.index')->with('error', '¡Vaya!... No hay suficientes existencias para realizar el movimiento');
                        }

                        $this->applyMovement($inventory, $validated['movement'], $validated['quantity']);
                    }
                } else {
                    $inventory = Inventory::where('product_id', $validated['product_id'])->where('team_id', $teamId)->firstOrFail();

                    if ($inventory->current_balance < $validated['quantity']) {
                        return Redirect::route('movements.index')->with('error', '¡Vaya!... No hay suficientes existencias para realizar el movimiento');
                    }

                    $this->applyMovement($inventory, $validated['movement'], $validated['quantity']);
                }

                $this->createMovement($validated, $inventory->id);
            });

            return Redirect::route('movements.index')->with('success', '¡El movimiento se ha registrado correctamente!');
        } catch (\Throwable $th) {
            return Redirect::route('movements.index')->with('error', '¡Vaya!... Error: ' . $th->getMessage());
        }
    }
    public function show($id): mixed
    {
        $inventory = Inventory::findOrFail($id);
        return Inertia::render('Vendor/Inventory/Show', ['inventory' => $inventory ]);
    }
    public function edit($id): mixed
    {
        $inventory = Inventory::findOrFail($id);
        return Inertia::render('Vendor/Inventory/Edit', ['inventory' => $inventory ]);
    }
    public function update(InventoryRequest $request, Inventory $inventory): RedirectResponse
    {
        $inventory->update($request->validated());
        return Redirect::route('inventories.index')->with('success', '¡El inventario ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Inventory::findOrFail($id)->delete();
        return Redirect::route('inventories.index')->with('success', '¡El inventario ha sido eliminado correctamente!');
    }
    private function createMovement(array $validated, int $inventoryId): void
    {
        Movement::create([
            'inventory_id' => $inventoryId,
            'user_id' => Auth::id(),
            'movement' => $validated['movement'],
            'type_movement' => $validated['type_movement'],
            'quantity' => $validated['quantity'],
            'date' => now(),
            'observation' => $validated['observation'] ?? null,
        ]);
    }
    private function applyMovement(Inventory $inventory, string $direction, int $quantity): void
    {
        $inventory->current_balance += $direction === 'Entrada' ? $quantity : -$quantity;
        $inventory->balancing_status = $inventory->current_balance < $inventory->minimum_balance ? 'Bajo' : 'Normal';
        $inventory->save();
    }
}