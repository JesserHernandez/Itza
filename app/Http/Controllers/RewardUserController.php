<?php

namespace App\Http\Controllers;

use App\Models\RewardUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RewardUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RewardUserController extends Controller
{
    public function index(Request $request): mixed
    {
        $rewardUsers = RewardUser::paginate();
        return Inertia::render('RewardUser/Index', ['rewardUsers' => $rewardUsers, 'i' => ($request->input('page', 1) - 1) * $rewardUsers->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('RewardUser/Create', ['rewardUser' => new RewardUser() ]);
    }
    public function store(RewardUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        RewardUser::create($validated);
        return Redirect::route('reward-users.index')->with('success', '¡La recompensa ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $rewardUser = RewardUser::findOrFail($id);
        return Inertia::render('RewardUser/Show', ['rewardUser' => $rewardUser ]);
    }
    public function edit($id): mixed
    {
        $rewardUser = RewardUser::findOrFail($id);
        return Inertia::render('RewardUser/Edit', ['rewardUser' => $rewardUser ]);
    }
    public function update(RewardUserRequest $request, RewardUser $rewardUser): RedirectResponse
    {
        $rewardUser->update($request->validated());
        return Redirect::route('reward-users.index')->with('success', '¡La recompensa ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        RewardUser::findOrFail($id)->delete();
        return Redirect::route('reward-users.index')->with('success', '¡La recompensa ha sido eliminada correctamente!');
    }
}