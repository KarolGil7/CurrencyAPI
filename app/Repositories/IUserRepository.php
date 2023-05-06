<?php

namespace App\Repositories;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserLoginResource;
use App\Models\User;

interface IUserRepository
{
    public function getByEmail(string $email): ?User;
    public function login(UserLoginRequest $request): ?UserLoginResource;
}
