<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DemoConversations
{
    public function ensureFor(User $user): void
    {
        DB::transaction(function () use ($user): void {
            User::query()->whereKey($user->id)->lockForUpdate()->first();

            $alreadyParticipates = Conversation::query()
                ->where(fn ($query) => $query
                    ->where('buyer_id', $user->id)
                    ->orWhere('user_id', $user->id))
                ->exists();

            if ($alreadyParticipates) {
                return;
            }

            $availableItems = Item::query()
                ->whereNotNull('user_id')
                ->where('user_id', '!=', $user->id)
                ->orderBy('id')
                ->get();

            $items = $availableItems
                ->unique('user_id')
                ->take(3)
                ->values();

            if ($items->count() < 3) {
                $selectedIds = $items->pluck('id');
                $items = $items
                    ->concat($availableItems->reject(fn (Item $item) => $selectedIds->contains($item->id)))
                    ->take(3)
                    ->values();
            }

            foreach ($items as $index => $item) {
                $this->createExampleConversation($user, $item, $index);
            }
        });
    }

    private function createExampleConversation(User $user, Item $item, int $index): void
    {
        $messages = [
            [$user->id, "Oi! Sobre {$item->name}, você aceita troca?"],
            [$item->user_id, 'Oi! Posso avaliar uma proposta de troca.'],
            [$user->id, "Podemos combinar um valor para {$item->name}?"],
            [$item->user_id, 'Podemos conversar sobre um valor justo. Aceito Pix.'],
            [$user->id, "Podemos combinar onde entregar {$item->name}?"],
            [$item->user_id, 'Claro! Podemos combinar a entrega em um local público.'],
        ];

        $oldestMessageAt = now()->subMinutes(35 + ($index * 50) + ((count($messages) - 1) * 3));
        $latestMessageAt = $oldestMessageAt->copy()->addMinutes((count($messages) - 1) * 3);

        $conversation = Conversation::query()->create([
            'item_id' => $item->id,
            'user_id' => $item->user_id,
            'buyer_id' => $user->id,
            'created_at' => $oldestMessageAt,
            'updated_at' => $latestMessageAt,
        ]);

        foreach ($messages as $messageIndex => [$senderId, $body]) {
            $createdAt = $oldestMessageAt->copy()->addMinutes($messageIndex * 3);

            $conversation->messages()->create([
                'sender_id' => $senderId,
                'body' => $body,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
