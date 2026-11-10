<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $avatar = $this->avatar;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'bio' => $this->bio,
            'avatar' => $avatar
                ? (str_starts_with($avatar, 'http') ? $avatar : asset('storage/'.$avatar))
                : null,
        ];
    }
}
