<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
    public function update(User $user, Team $team, array $input): void
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name_team' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:3', 'max:20'],
            'history' => ['required', 'text', 'min:3'],
            'city' => ['required', 'string', 'min:3', 'max:20'],
            'municipality' => ['required', 'string', 'min:3', 'max:20'],
            'phoneNumber' => ['required', 'string', 'max:20'],
            'ruc' => ['required', 'string', 'min:3', 'max:20'],
            'is_active' => ['required'],
            'photo_path' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateTeamName');

        $team->forceFill([
            'name_team' => $input['name_team'],
            'address' => $input['address'],
            'type' => $input['type'],
            'history' => $input['history'],
            'city' => $input['city'],
            'municipality' => $input['municipality'],
            'phoneNumber' => $input['phoneNumber'],
            'ruc' => $input['ruc'],
            'is_active' => $input['is_active'],
            'photo_path' => $input['photo_path'],
        ])->save();
    }
}