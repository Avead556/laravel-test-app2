<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::resource('/posts', PostController::class)
    ->except(['index', 'create', 'edit'])
    ->middleware(['auth:sanctum', 'user.userActivity']);
