<?php

namespace App\Actions\Fortify;

use App\Models\AdminDetail;
use App\Models\ClientDetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();
        
        $user_count = User::count();

        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $user_count == 0 ? 'super admin' : 'client',
        ]);

        if($user_count == 0) {
            AdminDetail::create([
                'user_id' => $user->id
            ]);
        } else {
            ClientDetail::create([
                'user_id' => $user->id
            ]);
        }
        

        return $user;
    }
}
