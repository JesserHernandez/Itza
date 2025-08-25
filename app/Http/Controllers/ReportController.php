<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(Request $request): mixed
    {
        $reports = Report::paginate();
        return Inertia::render('Report/Index', ['reports' => $reports, 'i' => ($request->input('page', 1) - 1) * $reports->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Report/Create', ['report' => new Report() ]);
    }
    public function store(ReportRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        Report::create($validated);
        return Redirect::route('reports.index')->with('success', '¡El reporte ha sido guardado correctamente!');
    }
    public function show($id): mixed
    {
        $report = Report::findOrFail($id);
        return Inertia::render('Report/Show', ['report' => $report ]);
    }
    public function edit($id): mixed
    {
        $report = Report::findOrFail($id);
        return Inertia::render('Report/Edit', ['report' => $report ]);
    }
    public function update(ReportRequest $request, Report $report): RedirectResponse
    {
        $report->update($request->validated());
        return Redirect::route('reports.index')->with('success', '¡El reporte ha sido actualizado correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        Report::findOrFail($id)->delete();
        return Redirect::route('reports.index')->with('success', '¡El reporte ha sido eliminado correctamente!');
    }
}