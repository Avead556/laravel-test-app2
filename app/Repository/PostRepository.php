<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostRepository
{
    public function store($request): Model|Post
    {
        return Post::query()->create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'user_id' => Auth::id(),
        ]);

    }

    public function find(int $postId): Model|Post
    {
        return Post::query()->findOrFail($postId);
    }

    public function update($postId, array $data): void
    {
        Post::query()->where('id', $postId)->update($data);
    }

    public function delete(int $postId): void
    {
        Post::query()->where('id', $postId)->delete();
    }

    public function paginate(int $page): LengthAwarePaginator
    {
        return Post::query()->paginate($page);
    }
}
