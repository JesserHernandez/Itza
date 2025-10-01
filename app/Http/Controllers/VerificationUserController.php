<?php

namespace App\Http\Controllers;

use App\Models\VerificationUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\VerificationUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class VerificationUserController extends Controller
{
    public function index(Request $request): mixed
    {
        $verificationUsers = VerificationUser::paginate();
        return Inertia::render('Vendor/VerificationUser/Index', ['verificationUsers' => $verificationUsers, 'i' => ($request->input('page', 1) - 1) * $verificationUsers->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Vendor/VerificationUser/Create', ['verificationUser' => new VerificationUser() ]);
    }
    public function store(VerificationUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        VerificationUser::create($validated);
        return Redirect::route('verification-users.index')->with('success', '¡Los documentos han sido guardados correctamente!');
    }
    public function show($id): mixed
    {
        $verificationUser = VerificationUser::findOrFail($id);
        return Inertia::render('Vendor/VerificationUser/Show', ['verificationUser' => $verificationUser ]);
    }
    public function edit($id): mixed
    {
        $verificationUser = VerificationUser::findOrFail($id);
        return Inertia::render('Vendor/VerificationUser/Edit', ['verificationUser' => $verificationUser ]);
    }
    public function update(VerificationUserRequest $request, VerificationUser $verificationUser): RedirectResponse
    {
        $verificationUser->update($request->validated());
        return Redirect::route('verification-users.index')->with('success', '¡Los documentos han sido guardados correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        VerificationUser::findOrFail($id)->delete();
        return Redirect::route('verification-users.index')->with('success', '¡Los documentos han sido guardados correctamente!');
    }
}