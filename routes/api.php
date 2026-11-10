<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ConversationMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::put('me', [AuthController::class, 'updateProfile']);

    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/{news}', [NewsController::class, 'show']);

    Route::post('items/{item}/like', [ItemController::class, 'toggleLike']);
    Route::post('items/{item}/save', [ItemController::class, 'toggleSave']);
    Route::apiResource('items', ItemController::class);
    Route::get('items/{item}/comments', [CommentController::class, 'index']);
    Route::post('items/{item}/comments', [CommentController::class, 'store']);
    Route::get('conversations', [ConversationController::class, 'index']);
    Route::post('conversations', [ConversationController::class, 'store']);
    Route::get('conversations/{conversation}/messages', [ConversationMessageController::class, 'index']);
    Route::post('conversations/{conversation}/messages', [ConversationMessageController::class, 'store']);
});
