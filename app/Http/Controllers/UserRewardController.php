<?php

namespace App\Http\Controllers;

use App\Models\UserReward;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRewardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserRewardController extends Controller
{
    public function index(Request $request): mixed
    {
        $userRewards = UserReward::paginate();
        return Inertia::render('Customer/UserReward/Index', ['userRewards' => $userRewards, 'i' => ($request->input('page', 1) - 1) * $userRewards->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('Customer/UserReward/Create', ['userReward' => new UserReward() ]);
    }
    public function store(UserRewardRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        UserReward::create($validated);
        return Redirect::route('rewards_users.index')->with('success', '¡La recompensa ha sido guardada correctamente!');
    }
    public function show($id): mixed
    {
        $userReward = UserReward::findOrFail($id);
        return Inertia::render('Customer/UserReward/Show', ['userReward' => $userReward ]);
    }
    public function edit($id): mixed
    {
        $userReward = UserReward::findOrFail($id);
        return Inertia::render('Customer/UserReward/Edit', ['userReward' => $userReward ]);
    }
    public function update(UserRewardRequest $request, UserReward $userReward): RedirectResponse
    {
        $userReward->update($request->validated());
        return Redirect::route('rewards_users.index')->with('success', '¡La recompensa ha sido actualizada correctamente!');
    }
    public function destroy($id): RedirectResponse
    {
        UserReward::findOrFail($id)->delete();
        return Redirect::route('rewards_users.index')->with('success', '¡La recompensa ha sido eliminada correctamente!');
    }
}