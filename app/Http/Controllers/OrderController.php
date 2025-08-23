<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request): mixed
    {
        $orders = Order::paginate();
        return Inertia::render('Order/Index', ['orders' => $orders, 'i' => ($request->input('page', 1) - 1) * $orders->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Order/Create', ['order' => new Order() ]);
    }
    public function store(OrderRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                
                $validated = $request->validated();

                $orderData = Arr::only($validated, ['sub_total','shipping_cost','total','shipping_number','estimated_time','warranty','order_date','addresses_user_id']) + ['code' => 'ORD-' . strtoupper(Str::uuid()),'user_id' => Auth::id() ];
                $paymentData = Arr::only($validated, ['amount_paid','payment_reference','payment_date','payment_method_user_id']);

                $order = Order::create($orderData);

                foreach ($validated['products'] ?? [] as $product) {
                    $order->orderDetails()->create($product);
                }

                if (!empty(array_filter($paymentData))) {
                    $order->payment()->create($paymentData);
                }
            });

            return Redirect::route('orders.index')->with('success', '¡La orden ha sido guardada correctamente!');
        } catch (\Throwable $th) {
            return Redirect::route('orders.index')->with('error', '¡Vaya!... Ocurrió un error al guardar la orden. Inténtalo de nuevo.');
        }
    }
    public function show($id): mixed
    {
        $order = Order::findOrFail($id);
        return Inertia::render('Order/Show', ['order' => $order ]);
    }
    public function edit($id): mixed
    {
        $order = Order::findOrFail($id);
        return Inertia::render('Order/Edit', ['order' => $order ]);
    }
    public function update(OrderRequest $request, Order $order): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $order) {
                
                $validated = $request->validated();
                $orderData = Arr::only($validated, ['sub_total', 'shipping_cost', 'total','shipping_number','estimated_time','warranty','order_date','payment_status','addresses_user_id']);
                $paymentData = Arr::only($validated, ['amount_paid','payment_reference','payment_date','payment_method_user_id']);

                $order->update( $orderData);

                $existingDetails = $order->orderDetails()->get()->keyBy('id');
                $incomingIds = collect($validated['products'] ?? [])->pluck('id')->filter()->all();
                $order->orderDetails()->whereNotIn('id', $incomingIds)->delete();

                foreach ($validated['products'] ?? [] as $product) {
                    if (isset($product['id']) && $existingDetails->has($product['id'])) {
                        $existingDetails[$product['id']]->update(Arr::except($product, ['id']));
                    } else {
                        $order->orderDetails()->create($product);
                    }
                }

                if (!empty(array_filter($paymentData))) {
                    if ($order->payment) {
                        $order->payment()->update($paymentData);
                    } else {
                        $order->payment()->create($paymentData);
                    }
                }
            });

            return Redirect::route('orders.index')->with('success', '¡La orden ha sido actualizada correctamente!');
        
        } catch (\Throwable $th) {
            return Redirect::route('orders.index')->with('error', '¡Vaya!... Ocurrió un error al actualizar la orden. Inténtalo de nuevo.');
        }
    }
    public function destroy($id): RedirectResponse
    {
        Order::findOrFail($id)->delete();
        return Redirect::route('orders.index')->with('success', '¡La orden ha sido eliminada correctamente!');
    }
}