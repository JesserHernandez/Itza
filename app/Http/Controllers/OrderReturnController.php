<?php

namespace App\Http\Controllers;

use App\Models\OrderReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrderReturnRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderReturnController extends Controller
{
    public function index(Request $request): mixed
    {
        $orderReturns = OrderReturn::paginate();
        return Inertia::render('OrderReturn/Index', ['orderReturns' => $orderReturns, 'i' => ($request->input('page', 1) - 1) * $orderReturns->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('OrderReturn/Create', ['orderReturn' => new OrderReturn() ]);
    }
    public function store(OrderReturnRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                
                $validated = $request->validated();
                $orderReturnData = Arr::only($validated, ['title', 'content', 'application_date','order_id']) + ['user_id' => Auth::id()];

                $orderReturn = OrderReturn::create($orderReturnData);

                foreach ($validated['items'] ?? [] as $item) {
                    $orderReturn->orderReturnItems()->create($item);
                }
            });

            return Redirect::route('order-returns.index')->with('success', '¡La devolución de la orden ha sido guardada correctamente!');
        
        } catch (\Throwable $th) {
            return Redirect::route('order-returns.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la devolución de la orden. Inténtalo de nuevo.');
        }
    }
    public function show($id): mixed
    {
        $orderReturn = OrderReturn::findOrFail($id);
        return Inertia::render('OrderReturn/Show', ['orderReturn' => $orderReturn ]);
    }
    public function edit($id): mixed
    {
        $orderReturn = OrderReturn::findOrFail($id);
        return Inertia::render('OrderReturn/Edit', ['orderReturn' => $orderReturn ]);
    }
    public function update(OrderReturnRequest $request, OrderReturn $orderReturn): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $orderReturn) {
                
                $validated = $request->validated();
                $returnData  = Arr::only($validated, ['title', 'content', 'revision_date', 'application_date', 'is_reviewed']);

                $orderReturn->update($returnData );

                $existingItems = $orderReturn->orderReturnItems()->get()->keyBy('id');
                $incomingIds = collect($validated['items'] ?? [])->pluck('id')->filter()->all();
                $orderReturn->orderReturnItems()->whereNotIn('id', $incomingIds)->delete();

                foreach ($validated['items'] ?? [] as $item) {
                    if (isset($item['id']) && $existingItems->has($item['id'])) {
                        $existingItems[$item['id']]->update(Arr::except($item, ['id']));
                    } else {
                        $orderReturn->orderReturnItems()->create($item);
                    }
                }
            });

            return Redirect::route('order-returns.index')->with('success', '¡La devolución de la orden ha sido actualizada correctamente!');
        
        } catch (\Throwable $th) {
            return Redirect::route('order-returns.index')->with('error', '¡Vaya!... Ocurrió un error al actualizar la devolución de la orden. Inténtalo de nuevo.');
        }
    }
    public function destroy($id): RedirectResponse
    {
        OrderReturn::findOrFail($id)->delete();
        return Redirect::route('order-returns.index')->with('success', '¡La devolución de la orden ha sido eliminada correctamente!');
    }
}