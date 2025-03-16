<?php

namespace App\Models\DTO;

use Illuminate\Database\Eloquent\Model;

class UserDTO 
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $Role,
        public readonly bool $IsActive
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            Role: $data['Role'],
            IsActive:$data['IsActive']
        );
    }
}
