<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return NewsResource::collection(News::query()->orderByDesc('published_at')->get());
    }

    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }
}
