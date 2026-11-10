<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class ConversationMessageController extends Controller
{
    public function index(Request $request, Conversation $conversation): AnonymousResourceCollection
    {
        $this->ensureCurrentUserConversation($conversation, $request->user()->id);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request, Conversation $conversation): JsonResponse
    {
        $this->ensureCurrentUserConversation($conversation, $request->user()->id);

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);
        $message->load('sender');

        return (new MessageResource($message))
            ->response()
            ->setStatusCode(201);
    }

    private function ensureCurrentUserConversation(Conversation $conversation, int $userId): void
    {
        abort_unless(
            (int) $conversation->buyer_id === $userId || (int) $conversation->user_id === $userId,
            404
        );
    }
}
