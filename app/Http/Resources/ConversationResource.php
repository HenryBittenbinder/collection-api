<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $currentUserId = (int) $request->user()->id;
        $otherUser = (int) $this->buyer_id === $currentUserId ? $this->user : $this->buyer;
        $item = $this->item;
        $lastMessage = $this->latestMessage;

        return [
            'id' => $this->id,
            'other_user' => [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'username' => $otherUser->username,
                'avatar' => $otherUser->avatar
                    ? (str_starts_with($otherUser->avatar, 'http') ? $otherUser->avatar : asset('storage/'.$otherUser->avatar))
                    : null,
            ],
            'item' => $item ? [
                'id' => $item->id,
                'name' => $item->name,
                'photo' => $item->photo
                    ? (str_starts_with($item->photo, 'http') ? $item->photo : asset('storage/'.$item->photo))
                    : null,
            ] : null,
            'last_message' => $lastMessage ? [
                'body' => $lastMessage->body,
                'created_at' => $lastMessage->created_at,
                'sent_by_me' => (int) $lastMessage->sender_id === $currentUserId,
            ] : null,
            'messages_count' => (int) ($this->messages_count ?? 0),
        ];
    }
}
