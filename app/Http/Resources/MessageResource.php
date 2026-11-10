<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $sender = $this->sender;

        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'sent_by_me' => (int) $this->sender_id === (int) $request->user()->id,
            'sender' => [
                'id' => $sender->id,
                'name' => $sender->name,
                'username' => $sender->username,
                'avatar' => $sender->avatar
                    ? (str_starts_with($sender->avatar, 'http') ? $sender->avatar : asset('storage/'.$sender->avatar))
                    : null,
            ],
        ];
    }
}
