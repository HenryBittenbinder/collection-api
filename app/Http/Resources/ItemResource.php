<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'brand' => $this->brand,
            'description' => $this->description,
            'condition' => $this->condition,
            'estimated_value' => $this->estimated_value,
            'asking_price' => $this->asking_price,
            'availability' => $this->availability,
            'photo' => $this->photo
                ? (str_starts_with($this->photo, 'http') ? $this->photo : asset('storage/'.$this->photo))
                : null,
            'owner' => $this->owner ? [
                'id' => $this->owner->id,
                'name' => $this->owner->name,
                'username' => $this->owner->username,
                'avatar' => $this->owner->avatar
                    ? (str_starts_with($this->owner->avatar, 'http') ? $this->owner->avatar : asset('storage/'.$this->owner->avatar))
                    : null,
            ] : null,
            'is_mine' => (int) $this->user_id === (int) $request->user()->id,
            'comments_count' => $this->comments_count ?? $this->comments()->count(),
            'likes_count' => (int) ($this->likes_count ?? 0),
            'liked_by_me' => (bool) ($this->liked_by_me ?? false),
            'saved_by_me' => (bool) ($this->saved_by_me ?? false),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
