<?php

namespace App\Repositories;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserLoginResource;
use App\Models\User;
use App\Repositories\IUserRepository;

class UserRepository implements IUserRepository
{
    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function login(UserLoginRequest $request): ?UserLoginResource
    {
        $user = $this->getByEmail($request->email);

        if ($user) {
            $isValidated = $user->validateForPassportPasswordGrant($request->password);
            if($isValidated)
            {
                $token = $user->createToken('AuthToken')->accessToken;
                $roles = $user->roles->pluck('name')->toArray();

                return new UserLoginResource($user->id, $user->email, $token, $roles);
            }
        }
        return null;
    }
}
