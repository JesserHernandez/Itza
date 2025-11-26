<?php

namespace App\Http\Controllers;

use App\Models\TransportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TransportServiceRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TransportServiceController extends Controller
{
    public function index(Request $request): mixed
    {
        $transportServices = TransportService::paginate();
        return Inertia::render('Administrator/TransportService/Index', ['transport_services' => $transportServices, 'i' => ($request->input('page', 1) - 1) * $transportServices->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Administrator/TransportService/Create', ['transport_service' => new TransportService()]);
    }
    public function store(TransportServiceRequest $request): RedirectResponse
    {
        TransportService::create($request->validated());
        return Redirect::route('transport_services.index')->with('success', '¡El servicio de transporte ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $transportService = TransportService::findOrFail($id);
        return Inertia::render('Administrator/TransportService/Show', ['transport_service' => $transportService ]);
    }
    public function edit($id): mixed
    {
        $transportService = TransportService::findOrFail($id);
        return Inertia::render('Administrator/TransportService/Edit', ['transport_service' => $transportService ]);
    }
    public function update(TransportServiceRequest $request, TransportService $transportService): RedirectResponse
    {
        $transportService->update($request->validated());
        return Redirect::route('transport_services.index')->with('success', '¡El servicio de transporte ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        TransportService::findOrFail($id)->delete();
        return Redirect::route('transport_services.index')->with('success', '¡El servicio de transporte ha sido eliminado correctamente!');
    }
}