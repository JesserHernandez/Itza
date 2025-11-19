<?php

namespace App\Actions\Fortify;

use App\Models\UserAddresse;
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

    public function create(array $array): User
    {
        Validator::make($array, [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'surname' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'gender' => ['required', 'string', 'min:3', 'max:10'],
            'phone_number' => ['required', 'string', 'min:3', 'max:20'],
            'identification_card' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
            'is_vendor' => ['required', 'boolean'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : ''
        ])->validate();
        return DB::transaction(function () use ($array) {
            return tap(User::create([
                'name' => $array['name'],
                'surname' => $array['surname'],
                'email' => $array['email'],
                'password' => Hash::make($array['password']),
                'gender' => $array['gender'],
                'phone_number' => $array['phone_number'],
                'identification_card' => $array['identification_card'],
                'is_vendor' => $array['is_vendor'],
            ]), function ( $user) use ($array) {
                $user->syncRoles('Cliente');
                if($user->is_vendor)
                {
                    $this->createTeam( $user,  $array);
                }
                else
                {
                    $this->createAddress( $user,  $array);
                }
            });
        });
    }
    protected function createTeam( User $user, array $array): void
    {
        Validator::make($array, [
            'teams' => ['required', 'array'],
            'teams.name_team' => ['required', 'string', 'min:3', 'max:255'],
            'teams.address' => ['required', 'string', 'min:3', 'max:255'],
            'teams.type' => ['required', 'string', 'min:3', 'max:20'],
            'teams.city' => ['required', 'string', 'min:3', 'max:20'],
            'teams.municipality' => ['required', 'string', 'min:3', 'max:20'],
            'teams.phoneNumber' => ['required', 'string', 'max:20'],
        ])->validate();

        $user->ownedTeams()->save(Team::forceCreate([
            'name_team' => $array['teams']['name_team'],
            'address' => $array['teams']['address'],
            'type' => $array['teams']['type'],
            'city' => $array['teams']['city'],
            'municipality' => $array['teams']['municipality'],
            'phoneNumber' => $array['teams']['phoneNumber'],
            'is_active' => true,
            'personal_team' => true,
            'user_id' => $user->id
        ]));
    }
    protected function createAddress( User $user, array $array): void
    {
        Validator::make($array, [
            'user_address' => ['required', 'array'],
            'user_address.address_type' => ['required', 'string', 'min:3', 'max:10'],
            'user_address.address_user' => ['required', 'string', 'min:3', 'max:255'],
            'user_address.postal_code' => ['required', 'string', 'min:3', 'max:10'],
            'user_address.address_city' => ['required', 'string', 'min:3', 'max:20'],
            'user_address.address_municipality' => ['required', 'string', 'min:3', 'max:20'],
        ])->validate();
        UserAddresse::create([
            'type'=> $array['user_address']['address_type'], 
            'address'=> $array['user_address']['address_user'], 
            'postal_code'=> $array['user_address']['postal_code'], 
            'city'=> $array['user_address']['address_city'], 
            'municipality'=> $array['user_address']['address_municipality'], 
            'is_active'=> true, 
            'is_main'=> true, 
            'user_id' => $user->id
            ]
        );
        $user->ownedTeams()->save(Team::forceCreate([
            'name_team' => explode(' ', $user->name, 2)[0]."'s Tienda",
            'is_active' => false,
            'personal_team' => true,
            'user_id' => $user->id,
        ]));
    }
}