<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    public function __construct(
        private int $userId,
        private ?string $email,
        private ?string $token,
        private array $roles
    )
    {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->userId,
            'email' => $this->email,
            'token' => $this->token,
            'roles' => $this->roles,
        ];
    }
}
