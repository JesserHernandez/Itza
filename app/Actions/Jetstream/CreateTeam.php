<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    public function create(User $user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name_team' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:3', 'max:20'],
            'history' => ['required', 'text', 'min:3'],
            'city' => ['required', 'string', 'min:3', 'max:20'],
            'municipality' => ['required', 'string', 'min:3', 'max:20'],
            'phoneNumber' => ['required', 'string', 'max:20'],
            'ruc' => ['required', 'string', 'min:3', 'max:20'],
            'photo_path' => ['mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name_team' => $input['name_team'],
            'address' => $input['address'],
            'type' => $input['type'],
            'history' => $input['history'],
            'city' => $input['city'],
            'municipality' => $input['municipality'],
            'phoneNumber' => $input['phoneNumber'],
            'ruc' => $input['ruc'],
            'is_active' => true,
            'photo_path' => $input['photo_path'],
            'personal_team' => false,
        ]));
        return $team;
    }
}