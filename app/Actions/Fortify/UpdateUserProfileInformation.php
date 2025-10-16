<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'surname' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id)],
            'gender' => ['required', 'string', 'min:3', 'max:10'],
            'phone_number' => ['required', 'string', 'min:3', 'max:20'],
            'is_vendor' => ['required'],
            'identification_card' => ['required', 'string', 'min:3', 'max:20', , Rule::unique('users')->ignore($user->id)],
            'experience' => ['nullable', 'text', 'min:3'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'surname' => $input['surname'],
                'email' => $input['email'],
                'gender' => $input['gender'],
                'phone_number' => $input['phone_number'],
                'identification_card' => $input['identification_card'],
                'is_vendor' => $input['is_vendor'],
                'experience' => $input['experience'],
            ])->save();
        }
    }
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'email' => $input['email'],
            'gender' => $input['gender'],
            'phone_number' => $input['phone_number'],
            'identification_card' => $input['identification_card'],
            'is_vendor' => $input['is_vendor'],
            'experience' => $input['experience'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
