<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required|string|min:8|confirmed',
            'city' => 'required|string|max:255',
            'photo' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $city = $input['city'];

        if ($input['city'] === 'Other' && !empty($input['other_city'])) {
            $city = $input['other_city'];
        }


        $photoPath = null;
        if ($input['photo']) {
            $photoPath = $input['photo']->store('photos', 'public');
        }


        $user = User::create([
            'name' => $input['name'],
            'slug' => Str::slug($input['name']),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'city' => $city,
            'profile_photo_path' => $photoPath,
            'trial_ends_at' => now()->addMonth(),
        ]);

        $user->createAsStripeCustomer();
 
        return $user;
    }
}
