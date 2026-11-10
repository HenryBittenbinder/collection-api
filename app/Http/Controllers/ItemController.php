<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $userId = $request->user()->id;
        $query = Item::query()
            ->with('owner')
            ->withCount(['comments', 'likes'])
            ->withExists([
                'likes as liked_by_me' => fn ($query) => $query->where('users.id', $userId),
                'saves as saved_by_me' => fn ($query) => $query->where('users.id', $userId),
            ])
            ->latest();

        if (request()->query('mine') === '1') {
            $query->where('user_id', $userId);
        }

        if (request()->query('liked') === '1') {
            $query->whereHas('likes', fn ($likes) => $likes->where('users.id', $userId));
        }

        if (request()->query('saved') === '1') {
            $query->whereHas('saves', fn ($saves) => $saves->where('users.id', $userId));
        }

        return ItemResource::collection($query->get());
    }

    public function show(Request $request, Item $item): ItemResource
    {
        return new ItemResource($this->loadResourceData($item, $request->user()));
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $data['user_id'] = $request->user()->id;

        $item = Item::create($data);
        $this->loadResourceData($item, $request->user());

        return (new ItemResource($item))->response()->setStatusCode(201);
    }

    public function update(UpdateItemRequest $request, Item $item): ItemResource
    {
        $data = $request->validated();
        $oldPhoto = $item->photo;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($data);

        if (isset($data['photo']) && $oldPhoto && !str_starts_with($oldPhoto, 'http')) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return new ItemResource($this->loadResourceData($item->refresh(), $request->user()));
    }

    public function destroy(Item $item): Response
    {
        if ($item->photo && !str_starts_with($item->photo, 'http')) {
            Storage::disk('public')->delete($item->photo);
        }

        $item->delete();

        return response()->noContent();
    }

    public function toggleLike(Request $request, Item $item): JsonResponse
    {
        $userId = $request->user()->id;
        $liked = $item->likes()->where('users.id', $userId)->exists();

        if ($liked) {
            $item->likes()->detach($userId);
        } else {
            $item->likes()->attach($userId);
        }

        return response()->json([
            'data' => [
                'liked' => ! $liked,
                'likes_count' => $item->likes()->count(),
            ],
        ]);
    }

    public function toggleSave(Request $request, Item $item): JsonResponse
    {
        $userId = $request->user()->id;
        $saved = $item->saves()->where('users.id', $userId)->exists();

        if ($saved) {
            $item->saves()->detach($userId);
        } else {
            $item->saves()->attach($userId);
        }

        return response()->json(['data' => ['saved' => ! $saved]]);
    }

    private function loadResourceData(Item $item, User $user): Item
    {
        return $item
            ->load('owner')
            ->loadCount(['comments', 'likes'])
            ->loadExists([
                'likes as liked_by_me' => fn ($query) => $query->where('users.id', $user->id),
                'saves as saved_by_me' => fn ($query) => $query->where('users.id', $user->id),
            ]);
    }
}
