<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    public function index(Item $item): AnonymousResourceCollection
    {
        return CommentResource::collection($item->comments()->with('user')->latest()->get());
    }

    public function store(StoreCommentRequest $request, Item $item): JsonResponse
    {
        $comment = $item->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);
        $comment->load('user');

        return (new CommentResource($comment))->response()->setStatusCode(201);
    }
}
