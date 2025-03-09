<?php

namespace App\Models\DTO;

use Illuminate\Database\Eloquent\Model;

class PostDTO 
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $UserId
    ) {}
    public static function fromArray(array $data ):self
    {
        return new self(
            id:$data['id'],
            title:$data["title"],
            content:$data["content"],
            UserId:$data["UserId"]
        );
    }

}
