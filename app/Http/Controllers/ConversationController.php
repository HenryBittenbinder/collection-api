<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Item;
use App\Services\DemoConversations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request, DemoConversations $demoConversations): AnonymousResourceCollection
    {
        $user = $request->user();
        $demoConversations->ensureFor($user);
        $userId = $user->id;
        $conversations = Conversation::query()
            ->where(fn ($query) => $query->where('buyer_id', $userId)->orWhere('user_id', $userId))
            ->with(['user', 'buyer', 'item', 'latestMessage.sender'])
            ->withCount('messages')
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at')
            ->orderByDesc('id')
            ->get();

        return ConversationResource::collection($conversations);
    }

    public function store(StoreConversationRequest $request): JsonResponse
    {
        $item = Item::query()->findOrFail($request->validated('item_id'));

        if ((int) $item->user_id === (int) $request->user()->id) {
            return response()->json([
                'message' => 'Você não pode conversar sobre o seu próprio item.',
            ], 422);
        }

        if ($item->user_id === null) {
            return response()->json([
                'message' => 'Este item não tem um colecionador disponível para conversar.',
            ], 422);
        }

        $conversation = Conversation::query()->firstOrCreate([
            'item_id' => $item->id,
            'user_id' => $item->user_id,
            'buyer_id' => $request->user()->id,
        ]);
        $wasCreated = $conversation->wasRecentlyCreated;

        $conversation
            ->load(['user', 'buyer', 'item', 'latestMessage.sender'])
            ->loadCount('messages');

        return (new ConversationResource($conversation))
            ->response()
            ->setStatusCode($wasCreated ? 201 : 200);
    }
}
