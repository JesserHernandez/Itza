<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'surname' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'email', 'min:3', 'max:50', 'unique:users'],
            'gender' => ['required', 'string', 'min:3', 'max:10'],
            'phone_number' => ['required', 'string', 'min:3', 'max:20'],
            'identification_card' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : ''
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'surname' => $input['surname'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'gender' => $input['gender'],
                'phone_number' => $input['phone_number'],
                'identification_card' => $input['identification_card'],
            ]), function ( $user) use ($input) {
                $this->createTeam( $user,  $input);
            });
        });
    }
    protected function createTeam( User $user, array $input): void
    {
        if ($user->is_vendor) {
            Validator::make($input, [
                'name_team' => ['required', 'string', 'min:3', 'max:255'],
                'address' => ['required', 'string', 'min:3', 'max:255'],
                'type' => ['required', 'string', 'min:3', 'max:20'],
                'city' => ['required', 'string', 'min:3', 'max:20'],
                'municipality' => ['required', 'string', 'min:3', 'max:20'],
                'phoneNumber' => ['required', 'string', 'max:20'],
                'photo_path' => ['mimes:jpg,jpeg,png', 'max:1024']
            ])->validate();

            $user->ownedTeams()->save(Team::forceCreate([
                'name_team' => $input['name_team'] ?? null,
                'address' => $input['address'] ?? null,
                'type' => $input['type'] ?? null,
                'city' => $input['city'] ?? null,
                'municipality' => $input['municipality'] ?? null,
                'phoneNumber' => $input['phoneNumber'] ?? null,
                'is_active' => true,
                'personal_team' => true,
                'user_id' => $user->id,
            ]));
        } else {
            $user->ownedTeams()->save(Team::forceCreate([
            'name_team' => explode(' ', $user->name, 2)[0]."'s Team",
            'is_active' => false,
            'personal_team' => true,
            'user_id' => $user->id,
            ]));
        }
    }
}